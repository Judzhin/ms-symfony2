<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\BlogBundle\Tests\Controller;

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
        $this->assertCount(3, $crawler->filter('h2'), 'There should be 3 displayed posts');
    }

}
