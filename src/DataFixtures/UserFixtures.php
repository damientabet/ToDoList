<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /**
     * @var
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->encoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 2; $i++) {
            if ($i == 1) {
                $user = new User();
                $user
                    ->setEmail('anonymous@test.com')
                    ->setPassword('anonymous')
                    ->setRoles((array)'ROLE_USER')
                    ->setUsername('Anonymous');
                $manager->persist($user);
            } else {
                $user = new User();
                $user
                    ->setEmail('administrateur@todolist.com')
                    ->setPassword($this->encoder->encodePassword($user, 'admintest'))
                    ->setRoles((array)'ROLE_ADMIN')
                    ->setUsername('Administrateur');
                $this->addReference('user', $user);
                $manager->persist($user);
            }
        }
        $manager->flush();
    }
}
