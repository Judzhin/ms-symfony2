<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\BlogBundle\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use MSBios\ModelBundle\Entity\Post;
use MSBios\ModelBundle\Repository\PostRepository;
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
        /** @var PostRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Post::class);

        return [
            'posts' => $repository->findAll(),
            'latest' => $repository->findLatest(3),
        ];
    }

    /**
     * @param $slug
     * @Route("/{slug}")
     * @Template()
     */
    public function showAction($slug)
    {
        /** @var Post $post */
        $post = $this->getDoctrine()
            ->getRepository(Post::class)
            ->findOneBy(['slug' => $slug]);

        if (is_null($post)) {
            throw $this->createNotFoundException('Post was not found');
        }

        return [
            'post' => $post,
        ];
    }

}
