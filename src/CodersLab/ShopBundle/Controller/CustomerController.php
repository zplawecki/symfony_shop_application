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
                ->add('address', 'text', ['label' => 'Adres zamieszkania'])
                ->add('save', 'submit', ['label' => 'Zarejestruj sie'])
                ->getForm();
        return $form;
    }

    /**
     * Creates a new Customer entity.
     *
     * @Route("/createCustomer", name="customer_registration")
     * @Template()
     */
    public function createCustomerAction(Request $req) {
        $repo = $this->getDoctrine()->getRepository('CodersLabShopBundle:Customer');
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
    
    /**
     * @Route("/newCustomer", name = "customer_new")
     * @Template()
     */
    public function newCustomerAction() {
        $customer = new Customer();

        $form = $this->customerForm($customer);

        return [
            'form' => $form->createView()
        ];
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

}
