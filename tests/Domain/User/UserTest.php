<?php

namespace Tests\Domain\User;

use App\Domain\User\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testCreate()
    {
        $user = new User('jean-michel', 'jm@test.com');

        // assert valid email
        $this->assertRegExp('/^.+\@\S+\.\S+$/', $user->getEmail());
    }
}
