<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class TaskFixtures
 * @package App\DataFixtures
 * @codeCoverageIgnore
 */
class TaskFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $task = new Task();
        $task->setTitle('Ma tâche');
        $task->setContent('Ma première tâche');
        $task->setCreatedAt(new \DateTime());
        $task->setUser($this->getReference('user'));

        $manager->persist($task);
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class
        );
    }
}
