<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AuthentificationTest extends TestCase
{
    public function test_login_page_is_displayed(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertSee('Connexion')
            ->assertSee('Identifiants par défaut');
    }

    #[DataProvider('userTypes')]
    public function test_users_are_automatically_redirected_to_their_space(string $userType): void
    {
        $this->post('/login', [
            'login' => $userType,
            'password' => $userType,
        ])->assertRedirect(route($userType.'.dashboard'));
        
        $this->withSession([
            'authenticated' => true,
            'user_type' => $userType,
        ])->get('/'.$userType.'/dashboard')
            ->assertOk()
            ->assertSee('Bienvenue, '.strtoupper($userType));
    }

    public function test_authenticated_user_cannot_access_another_user_type_space(): void
    {
        $this->withSession([
            'authenticated' => true,
            'user_type' => 'prof',
         ])->get('/admin/dashboard')
            ->assertRedirect(route('prof.dashboard'));
    }

    public function test_invalid_credentials_are_rejected(): void
    {
        $this->from('/login')->post('/login', [
            'login' => 'admin',
            'password' => 'incorrect',
        ])->assertRedirect('/login')
            ->assertSessionHasErrors('login');
    }

    public function test_user_type_spaces_redirect_guests_to_login(): void
    {
        foreach (['admin', 'cell', 'prof', 'eco'] as $userType) {
            $this->get('/'.$userType.'/dashboard')->assertRedirect(route('login'));
        }
    }

     public static function userTypes(): array
    {
       return [
            'admin' => ['admin'],
            'cell' => ['cell'],
            'prof' => ['prof'],
            'eco' => ['eco'],
        ];
    }
}
