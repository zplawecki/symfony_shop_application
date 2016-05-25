<?php

namespace CodersLab\ShopBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CodersLab\ShopBundle\Entity\Customer;
use CodersLab\ShopBundle\Form\CustomerType;
use CodersLab\ShopBundle\Entity\User;

/**
 * Customer controller.
 *
 * @Route("/customer")
 */
class CustomerController extends Controller {

    private function customerForm($customer) {


        $form = $this->createFormBuilder($customer)
                ->setAction($this->generateUrl('customer_registration'))
                ->add('name', 'text', ['label' => 'Imię'])
                ->add('surname', 'text', ['label' => 'Nazwisko'])
                ->add('mail', 'text', ['label' => 'Adres e-mail'])
                ->add('password', 'password', ['label' => 'Haslo'])
                ->add('address', 'text', ['label' => 'Adres e-mail'])
                ->add('save', 'submit', ['label' => 'Zarejestruj sie'])
                ->getForm();
        return $form;
    }
    
    /**
     * Creates a new Customer entity.
     *
     * @Route("/register", name="customer_registration")
     * @Method("POST")
     * @Template()
     */
    public function createCustomerAction(Request $req) {
        $repo = $this->getDoctrine()->getRepository('CodersBookBundle:Customer');
        $customer = new Customer();

        $form = $this->customerForm($customer);
        $form->handleRequest($req);

        if ($form->isSubmitted()) {
            if ($repo->findByName($customer->getSurname()) || $customer->getSurname() == '') {
                return [
                    'error' => 'Taka osoba już istnieje lub formularz jest pusty!'
                ];
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();

            return [
                'customer' => $customer
            ];
        }
    }

    private function updatePersonForm($person) {

        $form = $this->createFormBuilder($person)
                ->add('name', 'text', ['label' => 'Imię'])
                ->add('surname', 'text', ['label' => 'Nazwisko'])
                ->add('mail', 'text', ['label' => 'Adres e-mail'])
                ->add('password', 'password', ['label' => 'Haslo'])
                ->add('address', 'text', ['label' => 'Adres e-mail'])
                ->add('save', 'submit', ['label' => 'Zapisz zmiany'])
                ->getForm();
        return $form;
    }

    

    

    

   

    /**
     * Finds and displays a Customer entity.
     *
     * @Route("/{id}", name="customer_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CodersLabShopBundle:Customer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Customer entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Customer entity.
     *
     * @Route("/{id}/edit", name="customer_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CodersLabShopBundle:Customer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Customer entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Customer entity.
     *
     * @param Customer $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Customer $entity) {
        $form = $this->createForm(new CustomerType(), $entity, array(
            'action' => $this->generateUrl('customer_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Customer entity.
     *
     * @Route("/{id}", name="customer_update")
     * @Method("PUT")
     * @Template("CodersLabShopBundle:Customer:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CodersLabShopBundle:Customer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Customer entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('customer_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Customer entity.
     *
     * @Route("/{id}", name="customer_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CodersLabShopBundle:Customer')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Customer entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('customer'));
    }

    /**
     * Creates a form to delete a Customer entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('customer_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
