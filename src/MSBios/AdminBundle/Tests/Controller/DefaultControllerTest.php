<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class DefaultControllerTest
 * @package MSBios\AdminBundle\Tests\Controller
 */
class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        /** @var Crawler $crawler */
        $crawler = $client->request('GET', '/admin/author');

        $this->assertTrue($crawler->filter('html:contains("Author list")')->count() > 0);
    }
}
