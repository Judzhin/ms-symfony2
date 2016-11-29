<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\AdminBundle\Controller;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManager;
use MSBios\ModelBundle\Repository\AuthorRepository;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MSBios\ModelBundle\Entity\Author;
use MSBios\ModelBundle\Form\AuthorType;

/**
 * Author controller.
 *
 * @Route("/author")
 */
class AuthorController extends Controller
{
    /**
     * @return ObjectRepository|AuthorRepository
     */
    private function getRepository() {
        return $this->getDoctrine()
            ->getManager()
            ->getRepository(Author::class);
    }

    /**
     * Lists all Author entities.
     *
     * @return array
     *
     * @Route("/")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        return [
            'entities' => $this->getRepository()
                ->findAll(),
        ];
    }

    /**
     * Creates a new Author entity.
     *
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/")
     * @Method("POST")
     * @Template("AdminBundle:Author:new.html.twig")
     */
    public function createAction(Request $request)
    {
        /** @var Author $entity */
        $entity = new Author;

        /** @var Form $form */
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var EntityManager $em */
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl(
                'msbios_admin_author_show', [
                    'id' => $entity->getId()
            ]));
        }

        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Creates a form to create a Author entity.
     * @param Author $entity
     * @return \Symfony\Component\Form\Form
     */
    private function createCreateForm(Author $entity)
    {
        /** @var Form $form */
        $form = $this->createForm(new AuthorType, $entity, array(
            'action' => $this->generateUrl('msbios_admin_author_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', [
            'label' => 'Create'
        ]);

        return $form;
    }

    /**
     * Displays a form to create a new Author entity.
     *
     * @return array
     *
     * @Route("/new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        /** @var Author $entity */
        $entity = new Author;

        /** @var Form $form */
        $form = $this->createCreateForm($entity);

        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Finds and displays a Author entity.
     *
     * @param $id
     * @return array
     *
     * @Route("/{id}")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        /** @var Author $entity */
        $entity = $this->getRepository()
            ->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Author entity.');
        }

        /** @var Form $deleteForm */
        $deleteForm = $this->createDeleteForm($id);

        return [
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Displays a form to edit an existing Author entity.
     *
     * @param $id
     * @return array
     *
     * @Route("/{id}/edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        /** @var Author $entity */
        $entity = $this->getRepository()
            ->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Author entity.');
        }

        /** @var Form $editForm */
        $editForm = $this->createEditForm($entity);

        /** @var Form $deleteForm */
        $deleteForm = $this->createDeleteForm($id);

        return [
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Creates a form to edit a Author entity.
     *
     * @param Author $entity
     * @return \Symfony\Component\Form\Form
     */
    private function createEditForm(Author $entity)
    {
        /** @var Form $form */
        $form = $this->createForm(new AuthorType, $entity, [
            'action' => $this->generateUrl(
                'msbios_admin_author_update', ['id' => $entity->getId()]),
            'method' => 'PUT',
        ]);

        $form->add('submit', 'submit', ['label' => 'Update']);

        return $form;
    }

    /**
     * Edits an existing Author entity.
     *
     * @param Request $request
     * @param $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/{id}")
     * @Method("PUT")
     * @Template("AdminBundle:Author:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        /** @var Author $entity */
        $entity = $this->getRepository()
            ->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Author entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            /** @var EntityManager $em */
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirect($this->generateUrl(
                'msbios_admin_author_edit', ['id' => $id])
            );
        }

        return [
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Deletes a Author entity.
     *
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/{id}")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        /** @var Form $form */
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity = $this->getRepository()->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Author entity.');
            }

            /** @var EntityManager $em */
            $em = $this->getDoctrine()->getManager();
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('author'));
    }

    /**
     * Creates a form to delete a Author entity by id.
     *
     * @param $id
     * @return mixed
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('msbios_admin_author_delete', ['id' => $id]))
            ->setMethod('DELETE')
            ->add('submit', 'submit', ['label' => 'Delete'])
            ->getForm();
    }
}