<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\User;

abstract class TestCase extends BaseTestCase
{

    protected function tearDown(): void
    {
        $user = User::where('email', 'test@test.com')->first();
        if($user){
            $user->delete();
        }

        $user = User::where('email', 'test@testadmin.com')->first();
        if($user){
            $user->delete();
        }
        parent::tearDown();
    }
}
