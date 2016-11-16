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
<<<<<<< HEAD
     * @return void
=======
     *
>>>>>>> 46e484be86cbd4fb1f47cf78f48a16192611bbb6
     */
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertTrue($client->getResponse()->isSuccessful(), 'The response was not successful');
        $this->assertCount(3, $crawler->filter('h2'), 'There should be 3 displayed posts');
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
<<<<<<< HEAD
        $this->assertCount(9, $crawler->filter('h2'), 'There should be 3 displayed posts');
=======
        $this->assertEquals($post->getTitle(), $crawler->filter('h1')->text(), 'Invalid post title');
<<<<<<< HEAD
        $this->assertGreaterThanOrEqual(1, $crawler->filter('article.comment')->count(), 'There should be at least');
=======
>>>>>>> 46e484be86cbd4fb1f47cf78f48a16192611bbb6
>>>>>>> 4939439057aee307f0bec7226ed0a84fdc1fab00
    }
}
