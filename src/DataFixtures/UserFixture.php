<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i=0;$i<=10;$i++){
            $user = new User();
            $user->setMail("sample$i@mail.com")
                ->setName("npc n°$i")
                ->setPassword("sample")
                ->setImgLink("https://via.placeholder.com/150")
                ->setVerified(true);
            $manager->persist($user);
        }

        $manager->flush();
    }
}