<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * Test the created user is an admin
     *
     * @return void
     */
    public function test_create_admin_user()
    {
        $user = User::factory()->make([
            'role' => User::ROLE_ADMIN
        ]);
        
        $this->assertTrue($user->isAdmin());
    }
}
