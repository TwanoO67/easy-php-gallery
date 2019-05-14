<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\RefreshCollections;

use JWTAuth;
use App\Models\User;
use App\Models\Role;

class AuthTest extends TestCase
{
    use RefreshCollections;

    /** @test */
    function it_can_register_a_user()
    {
        // Register a user
        $user = [
            'name'     => 'Test',
            'email'    => 'test@gmail.com',
            'password' => 'secret1234',
            'password_confirmation' => 'secret1234',
        ];

        $this->json('POST', route('register'), $user)
            ->assertStatus(302);

        // Check user in DB
        $this->assertEquals(User::first()->email, 'test@gmail.com');
    }

    /** @test */
    function it_cant_register_invalid_users()
    {
        // Register an empty user
        $user = [];

        $this->json('POST', route('register'), $user)
            ->assertStatus(422)
            ->assertJsonStructure(['errors']);

        // Check no user in DB
        $this->assertNull(User::first());
    }

    /** @test */
    function it_can_login_as_user()
    {
        // Create user
        $user = factory(User::class)->create([
            'password' => bcrypt('correct-password'),
        ]);

        $goodCredentials = [
            'email'    => $user->email,
            'password' => 'correct-password',
        ];

        // Attempt login
        $this->json('POST', route('login'), $goodCredentials)
            ->assertStatus(302);
    }

    /** @test */
    function it_cant_login_with_invalid_credentials()
    {
        // Create user
        $user = factory(User::class)->create([
            'password' => bcrypt('correct-password'),
        ]);

        $badCredentials = [
            'email'    => $user->email,
            'password' => 'incorrect-password',
        ];

        // Attempt login
        $this->json('POST', route('login'), $badCredentials)
            ->assertStatus(422)
            ->assertJson([
                "message"=> "The given data was invalid.",
                "errors"=> [
                    "email"=> [
                        "These credentials do not match our records."
                    ]
                ]
            ]);
    }

    /** @test */
    /*function it_gives_current_connected_user()
    {
        $role = Role::create(['name' => 'admin']);

        $admin = factory(User::class)->create([
            'email' => 'admin@easyphpgallery.fr',
        ]);

        $admin->assignRole($role);

        $this->actingAs($admin);

        // Get current auth'd user + roles
        $this->json('GET', route('auth.user'))
            ->assertJson([
                'user' => [
                    'email'     => 'admin@easyphpgallery.fr',
                    'all_roles' => ['admin'],
                    'all_permissions' => [],
                ],
            ]);
    }*/

    /** @test */
   /* function it_correctly_logs_out_the_current_user()
    {
        // First login
        $user = factory(User::class)->create(['email' => 'test@easyphpgallery.fr']);
        $this->actingAs($user);
        $token = JWTAuth::fromUser($user);

        // Logout
        $this->json('POST', route('auth.logout'), ['token' => $token])
            ->assertStatus(200);

        // Get current auth'd user
        $this->json('GET', route('auth.user'))
            // We cannot check current user as we're logged out
            ->assertStatus(401)
            ->assertJson([
                'error' => 'unauthorized',
            ]);
    }*/

    /** @test */
    /*function it_can_refresh_current_user()
    {
        // Login
        $user = factory(User::class)->create(['email' => 'test@easyphpgallery.fr']);
        $this->actingAs($user);
        $token = JWTAuth::fromUser($user);

        // Get a fresh new token
        $this->json('GET', route('auth.refresh'), ['token' => $token])
            ->assertStatus(200)
            ->assertJsonStructure(['token']);
    }*/
}
