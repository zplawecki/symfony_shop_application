<?php

namespace CodersLab\ShopBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CodersLab\ShopBundle\Entity\Basket;
use CodersLab\ShopBundle\Form\BasketType;

/**
 * Basket controller.
 *
 * @Route("/basket")
 */
class BasketController extends Controller
{

    /**
     * Lists all Basket entities.
     *
     * @Route("/", name="basket")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CodersLabShopBundle:Basket')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Basket entity.
     *
     * @Route("/", name="basket_create")
     * @Method("POST")
     * @Template("CodersLabShopBundle:Basket:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Basket();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('basket_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Basket entity.
     *
     * @param Basket $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Basket $entity)
    {
        $form = $this->createForm(new BasketType(), $entity, array(
            'action' => $this->generateUrl('basket_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Basket entity.
     *
     * @Route("/new", name="basket_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Basket();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Basket entity.
     *
     * @Route("/{id}", name="basket_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CodersLabShopBundle:Basket')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Basket entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Basket entity.
     *
     * @Route("/{id}/edit", name="basket_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CodersLabShopBundle:Basket')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Basket entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Basket entity.
    *
    * @param Basket $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Basket $entity)
    {
        $form = $this->createForm(new BasketType(), $entity, array(
            'action' => $this->generateUrl('basket_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Basket entity.
     *
     * @Route("/{id}", name="basket_update")
     * @Method("PUT")
     * @Template("CodersLabShopBundle:Basket:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CodersLabShopBundle:Basket')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Basket entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('basket_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Basket entity.
     *
     * @Route("/{id}", name="basket_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CodersLabShopBundle:Basket')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Basket entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('basket'));
    }

    /**
     * Creates a form to delete a Basket entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('basket_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
