<?php

namespace Tests\Unit\AppBundle\Controller;

use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\User\UserInterface;

class UserTest extends TestCase
{
    private $user;

    public function setUp()
    {
        $this->user = new User();
    }

    public function tearDown()
    {
        $this->user = null;
    }

    public function testUserShouldImplementUserInterface()
    {
        $this->assertInstanceOf(UserInterface::class, $this->user);
    }

    public function testUserShouldImplementSerializable()
    {
        $this->assertInstanceOf(\Serializable::class, $this->user);
    }
}
