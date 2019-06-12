<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Post;
use Nelmio\Alice\Fixtures;

class LoadFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // $post = new Post();
        // $post->setTitle('Test Title Keyboard ');
        // $post->setDescription('Ergonomic and stylish! ');
        // $post->setstatus((bool) random_int(0, 1));
        // $post->setpostedAt();
        // $post->setupdated_at();
        // $manager->persist($post);
        // $manager->flush();

        $objects = Fixtures::load(__DIR__.'/fixtures.yml', $manager);
    }
}
