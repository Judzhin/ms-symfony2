<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\BlogBundle\Tests\Controller;

use Doctrine\ORM\EntityManager;
use MSBios\ModelBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class PostControllerTest
 * @package MSBios\BlogBundle\Tests\Controller
 */
class PostControllerTest extends WebTestCase
{
    /**
     * @test
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

    /**
     * @test
     */
    public function testShow()
    {
        /** @var Clie $client */
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
        $this->assertGreaterThanOrEqual(
            count($post->getComments()),
            $crawler->filter('.media-body')->count(),
            'There should be at least'
        );
    }

    /**
     * @test
     */
    public function testCreateComment()
    {
        /** @var Client $client */
        $client = static::createClient();

        /** @var Post $post */
        $post = $client->getContainer()
            ->get('doctrine')
            ->getRepository(Post::class)
            ->findFirst();

        /** @var string $url */
        $url = "/{$post->getSlug()}";

        /** @var Crawler $crawler */
        $crawler = $client->request('GET', $url);

        $buttonCrawlerNode = $crawler->selectButton('Send');

        $form = $buttonCrawlerNode->form(
            [
                'msbios_modelbundle_comment[authorName]' => 'A hunble commenter',
                'msbios_modelbundle_comment[message]' => "Hi! I`m commenting about Symfony2!",
            ]
        );

        $client->submit($form);

        $this->assertTrue(
            $client->getResponse()->isRedirect($url, 'There was no redirect after submitting the')
        );

        /** @var Crawler $crawler */
        $crawler = $client->followRedirect();

        $this->assertCount(
            1,
            $crawler->filter('html:contains("Your comment was submitted successfully")'),
            'There was not any confirmation message'
        );
    }
}
