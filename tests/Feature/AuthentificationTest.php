<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    public function test_login_page_is_displayed(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertSee('Connexion')
            ->assertSee('Identifiants par défaut');
    }

    public function test_admin_can_login_with_default_credentials(): void
    {
        $this->post('/login', [
            'login' => 'admin',
            'password' => 'admin',
        ])->assertRedirect(route('dashboard'));

        $this->withSession(['authenticated' => true])
            ->get('/dashboard')
            ->assertOk()
            ->assertSee('Bienvenue, admin');
    }

    public function test_invalid_credentials_are_rejected(): void
    {
        $this->from('/login')->post('/login', [
            'login' => 'admin',
            'password' => 'incorrect',
        ])->assertRedirect('/login')
            ->assertSessionHasErrors('login');
    }

    public function test_dashboard_redirects_guests_to_login(): void
    {
        $this->get('/dashboard')->assertRedirect(route('login'));
    }
}
