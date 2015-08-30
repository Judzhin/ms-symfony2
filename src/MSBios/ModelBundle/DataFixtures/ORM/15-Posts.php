<?php
namespace MSBios\ModelBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MSBios\ModelBundle\Entity\Post;

/**
 * Class Posts
 * @package MSBios\ModelBundle\DataFixtures\ORM
 */
class Posts extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $manager->persist(self::factoryPost($manager, 'Judzhin'));
        $manager->persist(self::factoryPost($manager, 'Judzhin'));
        $manager->persist(self::factoryPost($manager, 'Judzhin'));
        $manager->persist(self::factoryPost($manager, 'John'));
        $manager->persist(self::factoryPost($manager, 'John'));
        $manager->persist(self::factoryPost($manager, 'John'));
        $manager->persist(self::factoryPost($manager, 'Elsa'));
        $manager->persist(self::factoryPost($manager, 'Elsa'));
        $manager->persist(self::factoryPost($manager, 'Elsa'));
        $manager->flush();
    }

    /**
     * @param ObjectManager $objectManager
     * @param $name
     * @return Post
     */
    private static function factoryPost(ObjectManager $objectManager, $name)
    {
        $post = new Post;
        $post->setTitle('Lorem Ipsum is simply dummy text of the printing and typesetting industry');
        $post->setDescription('Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.');
        $post->setAuthor($objectManager->getRepository('ModelBundle:Author')->findOneBy(['name' => $name]));
        return $post;
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 15;
    }
}