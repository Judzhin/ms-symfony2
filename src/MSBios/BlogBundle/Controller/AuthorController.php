<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\BlogBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Util\Debug;
use Doctrine\ORM\EntityManager;
use MSBios\ModelBundle\Entity\Author;
use MSBios\ModelBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class AuthorController
 * @package MSBios\BlogBundle\Controller
 */
class AuthorController extends Controller
{
    /**
     * @param $slug
     * @Route("/author/{slug}")
     * @Template()
     */
    public function showAction($slug)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine();

        /** @var Author $author */
        $author = $em->getRepository(Author::class)
            ->findOneBy(
                [
                    'slug' => $slug,
                ]
            );

        if (is_null($author)) {
            throw $this->createNotFoundException('Author was not found');
        }

        /** @var ArrayCollection $posts */
        $posts = $em->getRepository(Post::class)->findBy(
            [
                'author' => $author,
            ]
        );

        return [
            'author' => $author,
            'posts' => $posts,
        ];

    }
}
