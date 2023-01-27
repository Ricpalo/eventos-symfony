<?php

namespace LugaresBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use LugaresBundle\Entity\Lugares;
use Nelmio\Alice\Fixtures;

class LoadFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager) {
        Fixtures::load(__DIR__.'fixtures.yml', $manager);
    }
}