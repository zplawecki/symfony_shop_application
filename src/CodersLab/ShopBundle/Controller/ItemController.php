<?php

namespace CodersLab\ShopBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CodersLab\ShopBundle\Entity\Item;
use CodersLab\ShopBundle\Form\ItemType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Item controller.
 *
 * @Route("/item")
 */
class ItemController extends Controller {

    private function itemForm($item) {


        $form = $this->createFormBuilder($item)
                ->setAction($this->generateUrl('item_create'))
                ->add('name', 'text', ['label' => 'Nazwa'])
                ->add('description', 'text', ['label' => 'Opis'])
                ->add('price', 'text', ['label' => 'Cena'])
                ->add('save', 'submit', ['label' => 'Dodaj przedmiot'])
                ->getForm();
        return $form;
    }

    /**
     * Lists all Item entities.
     *
     * @Route("/allItems", name="all_items")
     * @Method("GET")
     * @Template()
     */
    public function showAllItemsAction() {
        $em = $this->getDoctrine()->getManager();

        $items = $em->getRepository('CodersLabShopBundle:Item')->findAll();

        return array(
            'items' => $items,
        );
    }

    /**
     * Creates a new Item entity.
     *
     * @Route("/", name="item_create")
     * @Method("POST")
     */
    public function createAction(Request $request) {
        $loggedUser = $this->getUser();
        if ($loggedUser->hasRole('ROLE_ADMIN')) {

            $item = new Item();
            $form = $this->itemForm($item);
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($item);
                $em->flush();

                return $this->redirect($this->generateUrl('item_show', array('id' => $item->getId())));
                return new Response('dodano nowy przedmiot');
            }
        }
    }

    /**
     * Displays a form to create a new Item entity.
     *
     * @Route("/new", name="item_new")
     * @Method("GET")
     * @Template()
     */
    public function newItemAction() {
        $item = new Item();
        $form = $this->itemForm($item);

        return array(
            'item' => $item,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Item entity.
     *
     * @Route("/{id}", name="item_show")
     * @Method("GET")
     * @Template()
     */
    public function showOneAction($id) {

        $em = $this->getDoctrine()->getManager();

        $item = $em->getRepository('CodersLabShopBundle:Item')->find($id);

        if (!$item) {
            throw $this->createNotFoundException('Unable to find Item entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'item' => $item,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Item entity.
     *
     * @Route("/{id}/edit", name="item_edit")
     * @Method("GET")
     * @Template()
     */
    public function editItemAction($id) {

        $loggedUser = $this->getUser();
        if ($loggedUser->hasRole('ROLE_ADMIN')) {

            $em = $this->getDoctrine()->getManager();

            $item = $em->getRepository('CodersLabShopBundle:Item')->find($id);

            if (!$item) {
                throw $this->createNotFoundException('Unable to find Item entity.');
            }

            $editForm = $this->createEditForm($item);
            $deleteForm = $this->createDeleteForm($id);

            return array(
                'item' => $item,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            );
        }
    }

    /**
     * Creates a form to edit a Item entity.
     *
     * @param Item $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Item $item) {
        $form = $this->createForm(new ItemType(), $item, array(
            'action' => $this->generateUrl('item_update', array('id' => $item->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Item entity.
     *
     * @Route("/{id}", name="item_update")
     * @Method("PUT")
     * @Template("CodersLabShopBundle:Item:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {

        $loggedUser = $this->getUser();
        if ($loggedUser->hasRole('ROLE_ADMIN')) {

            $em = $this->getDoctrine()->getManager();

            $item = $em->getRepository('CodersLabShopBundle:Item')->find($id);

            if (!$item) {
                throw $this->createNotFoundException('Unable to find Item entity.');
            }

            $deleteForm = $this->createDeleteForm($id);
            $editForm = $this->createEditForm($item);
            $editForm->handleRequest($request);

            if ($editForm->isValid()) {
                $em->flush();

                return $this->redirect($this->generateUrl('item_edit', array('id' => $id)));
            }

            return array(
                'item' => $item,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            );
        }
    }

    /**
     * Deletes a Item entity.
     *
     * @Route("/{id}", name="item_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {

        $loggedUser = $this->getUser();
        if ($loggedUser->hasRole('ROLE_ADMIN')) {

            $form = $this->createDeleteForm($id);
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $item = $em->getRepository('CodersLabShopBundle:Item')->find($id);

                if (!$item) {
                    throw $this->createNotFoundException('Unable to find Item entity.');
                }

                $em->remove($item);
                $em->flush();
            }

            return $this->redirect($this->generateUrl('item'));
        }
    }

    /**
     * Creates a form to delete a Item entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('item_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

    /**
     * @Route("/update/{id}", name = "item_update")
     * @Method("GET")
     * @Template()
     */
    public function updateItemGetAction($id) {
        $repo = $this->getDoctrine()->getRepository('CodersLabShopBundle:Item');

        $item = $repo->find($id);
        if (!$item) {
            return [
                'error' => 'Wystąpił błąd, brak takiego przedmiotu w bazie danych!'
            ];
        }
        $form = $this->itemForm($item);
        return[
            'form' => $form->createView()
        ];
    }

    /**
     * @Route("/update/{id}", name = "updated_item_save")
     * @Method("POST")
     * @Template()
     */
    public function updateItemPostAction(Request $req, $id) {
        $repo = $this->getDoctrine()->getRepository('CodersLabShopBundle:Item');
        $item = $repo->find($id);
        $form = $this->itemForm($item, $item->getId());
        $form->handleRequest($req);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();
        }
        return [
            'form' => $form->createView(),
            'success' => true
        ];
    }

    

}
