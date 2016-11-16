<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\BlogBundle\Tests\Controller;

use Doctrine\ORM\EntityManager;
use MSBios\ModelBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class PostControllerTest
 * @package MSBios\BlogBundle\Tests\Controller
 */
class PostControllerTest extends WebTestCase
{
    /**
     *
     */
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertTrue($client->getResponse()->isSuccessful(), 'The response was not successful');

        /** @var array $posts */
        $posts = $client->getContainer()
            ->get('doctrine')
            ->getManager()
            ->getRepository(Post::class)
            ->findAll();

        /** @var int $countPosts */
        $countPosts = count($posts);

        $this->assertCount($countPosts, $crawler->filter('h2'), "There should be {$countPosts} displayed posts");
    }

    public function testShow()
    {
        /** @var  $client */
        $client = static::createClient();

        /** @var Post $post */
        $post = $client->getContainer()
            ->get('doctrine')
            ->getManager()
            ->getRepository(Post::class)
            ->findFirst();

        /** @var  $crawler */
        $crawler = $client->request('GET', '/'.$post->getSlug());
        $this->assertTrue($client->getResponse()->isSuccessful(), 'The response was not successful');
        $this->assertEquals($post->getTitle(), $crawler->filter('.blog-post-title')->text(), 'Invalid post title');
        $this->assertGreaterThanOrEqual(count($post->getComments()), $crawler->filter('.media-body')->count(), 'There should be at least');
    }
}
