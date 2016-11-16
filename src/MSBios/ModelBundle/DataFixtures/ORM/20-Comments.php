<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\ModelBundle\DataFixtures\ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MSBios\ModelBundle\Entity\Comment;
use MSBios\ModelBundle\Entity\Post;

/**
 * Class Comments
 * @package MSBios\ModelBundle\DataFixtures\ORM
 */
class Comments extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /** @var ArrayCollection $posts */
        $posts = $manager->getRepository(Post::class)->findAll();

        /** @var Post $post */
        foreach ($posts as $post) {
            /** @var Comment $comment */
            $comment = new Comment;
            $comment->setAuthorName('Someone');
            $comment->setMessage(
                "Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus."
            );
            $comment->setPost($post);
            $manager->persist($comment);
        }

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 20;
    }
}