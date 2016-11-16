<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\BlogBundle\Controller;

use MSBios\ModelBundle\Entity\Post;
use MSBios\ModelBundle\Form\CommentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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

        return [
            'post' => $post,
            'form' => $this->createForm(new CommentType)->createView(),
        ];
    }

    /**
     * @param Request $request
     * @param $slug
     * @return array
     *
     * @Route("/{slug}/create-comment")
     * @Method("POST")
     * @Template("@Blog/Post/show.html.twig")
     */
    public function createCommentAction(Request $request, $slug)
    {
        return [];
    }
}
