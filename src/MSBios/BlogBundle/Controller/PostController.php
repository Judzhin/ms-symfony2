<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\BlogBundle\Controller;

use Doctrine\ORM\EntityManager;
use MSBios\ModelBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class PostController
 * @package MSBios\BlogBundle\Controller
 */
class PostController extends Controller
{
    /**
     * @return array
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        /** @var array $posts */
        $posts = $this->getDoctrine()->getRepository(Post::class)->findAll();

        return [
            'posts' => $posts,
        ];
    }

}
