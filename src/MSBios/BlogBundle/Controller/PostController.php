<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\BlogBundle\Controller;

use Doctrine\ORM\EntityManager;
use MSBios\ModelBundle\Entity\Comment;
use MSBios\ModelBundle\Entity\Post;
use MSBios\ModelBundle\Form\CommentType;
use MSBios\ModelBundle\Repository\PostRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PostController
 * @package MSBios\BlogBundle\Controller
 */
class PostController extends Controller
{
    /**
     * @return array
     *
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        /** @var PostRepository $repository */
        $repository = $this->getDoctrine()
            ->getRepository(Post::class);

        return [
            'posts' => $repository->findAll(),
            'latest' => $repository->findLatest(3)
        ];
    }

    /**
     * -param $slug
     * @param Post $post
     * @return array
     *
     * @Route("/{slug}")
     * - ParamConverter("post", class="ModelBundle:Post", options={"slug"="slug"})
     * @ParamConverter("post", class="MSBios\ModelBundle\Entity\Post", options={"slug"="slug"})
     * @Template()
     */
    // public function showAction($slug)
    public function showAction(Post $post = null)
    {
        // Example 1
        // if (!($post = $this->getDoctrine()
        //     ->getRepository(Post::class)
        //     ->findOneBySlug($slug))) {
        //     throw $this->createNotFoundException('Post was not found');
        // }

        // Example 2
        if (!$post) {
            throw $this->createNotFoundException('Post was not found');
        }

        return [
            'post' => $post,
            'form' => $this->createForm(new CommentType)
                ->createView(),
        ];
    }

    /**
     * @param Request $request
     * @param $slug
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/{slug}/create-comment")
     * @Method("POST")
     * @Template("@Blog/Post/show.html.twig")
     */
    public function createCommentAction(Request $request, $slug)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()
            ->getManager();

        /** @var Post $post */
        $post = $em->getRepository(Post::class)
            ->findOneSlug($slug);

        if (!$post) {
            throw $this->createNotFoundException('Post was not found');
        }

        /** @var Comment $comment */
        $comment = new Comment;
        $comment->setPost($post);

        /** @var Form $form */
        $form = $this->createForm(new CommentType, $comment);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($comment);
            $em->flush();

            $this->get('session')
                ->getFlashBag()
                ->add('success', 'Your comment was submitted succesfully');

            return $this->redirect(
                $this->generateUrl('msbios_blog_post_show', ['slug' => $slug])
            );
        }

        return [
            'post' => $post,
            'form' => $form->createView()
        ];
    }
}
