<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use APP\Entity\User;
class Userf extends Fixture
{
    public function load(ObjectManager $manager)
    {
            $user = new User();


        $manager->flush();
    }
}
