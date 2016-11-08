<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\BlogBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
     * @return array
     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository(Post::class);

        return ['posts' => $repository->findAll(), 'latest' => $repository->findLatest(3),];
    }

    /**
     * @param $slug
     * @Route("/{slug}")
     * @Template()
     */
    public function showAction($slug)
    {
        /** @var Post $post */
        $post = $this->getDoctrine()->getRepository(Post::class)->findOneBy(['slug' => $slug]);

        if (is_null($post)) {
            throw $this->createNotFoundException('Post was not found');
        }

        return ['post' => $post];
    }

}
