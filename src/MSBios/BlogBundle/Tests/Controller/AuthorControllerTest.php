<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\BlogBundle\Tests\Controller;

use MSBios\ModelBundle\Entity\Author;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class AuthorControllerTest
 * @package MSBios\BlogBundle\Tests\Controller
 */
class AuthorControllerTest extends WebTestCase
{
    /**
     *
     */
    public function testShow()
    {
        /** @var Client $client */
        $client = static::createClient();
        /** @var Author $author */
        $author = $client->getContainer()
            ->get('doctrine')
            ->getManager()
            ->getRepository(Author::class)
            ->findFirst();

        /** @var Crawler $crawler */
        $crawler = $client->request('GET', '/author/'.$author->getSlug());

        $this->assertTrue($client->getResponse()->isSuccessful(), 'The response was not succesful');

        /** @var int $postsCount */
        $postsCount = $author->getPosts();
        $this->assertCount($postsCount, $crawler->filter('h2'), "There should be {$postsCount} posts");
    }
}
