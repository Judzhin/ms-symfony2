<?php
namespace MSBios\ModelBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MSBios\ModelBundle\Entity\Author;

/**
 * Class Authors
 * @package MSBios\ModelBundle\DataFixtures\ORM
 */
class Authors extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $a1 = new Author();
        $a1->setName('Judzhin');
        $manager->persist($a1);

        $a2 = new Author();
        $a2->setName('John');
        $manager->persist($a2);

        $a3 = new Author();
        $a3->setName('Elsa');
        $manager->persist($a3);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 10;
    }
}