<?php

namespace CodersLab\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\UserBundle\Doctrine\UserManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Admin controller.
 * @Route("/admin")
 */
class UserController extends Controller {

    /**
     * @Route("/new/{id}", name="new_admin")
     * 
     */
    public function createAdminAction(Request $req, $id) {


        $repo = $this->getDoctrine()->getRepository('CodersLabShopBundle:User');
        $em = $this->getDoctrine()->getManager();
        $newAdmin = $repo->find($id);


        if ($newAdmin) {


            $newAdmin->addRole('ROLE_ADMIN');

            $em = $this->getDoctrine()->getManager();
            $em->persist($newAdmin);
            $em->flush();

            return new Response('admin dodany');
        }
    }

    /**
     * @Route("/panel")
     */
    public function adminPanelAction() {
        return [];
    }

    /**
     * @Route("/delete/{id}", name = "user_delete")
     * 
     */
    public function deleteUserAction($id) {

        $loggedUser = $this->getUser();
        if ($loggedUser->hasRole('ROLE_ADMIN')) {

            $repo = $this->getDoctrine()->getRepository('CodersLabShopBundle:User');
            $em = $this->getDoctrine()->getManager();
            $deletedUser = $repo->find($id);
            if ($deletedUser) {
                $em->remove($deletedUser);
                $em->flush();
            }

            return new Response('uzytkownik usuniety');
        }

        return new Response('brak dostępu');
    }

    /**
     * @Route("/showAll", name = "show_all")
     * @Template()
     */
    public function showAllAction() {

        $loggedUser = $this->getUser();
        if ($loggedUser->hasRole('ROLE_ADMIN')) {

            $repo = $this->getDoctrine()->getRepository('CodersLabShopBundle:User');
            $em = $this->getDoctrine()->getManager();
            $allUsers = $repo->findAll();
            dump($allUsers);
            return [
                
                'allUsers' => $allUsers
            ];
        }
    }

    private function customerForm($customer) {


        $form = $this->createFormBuilder($customer)
                ->setAction($this->generateUrl('customer_registration'))
                ->add('username', 'text', ['label' => 'Login'])
                ->add('name', 'text', ['label' => 'Imię'])
                ->add('surname', 'text', ['label' => 'Nazwisko'])
                ->add('mail', 'text', ['label' => 'Adres e-mail'])
                ->add('password', 'password', ['label' => 'Haslo'])
                ->add('address', 'text', ['label' => 'Adres zamieszkania'])
                ->add('save', 'submit', ['label' => 'Zarejestruj sie'])
                ->getForm();
        return $form;
    }

//prawidlowa sciezka do wszystkich plikow to /customer/{nasz route}, itp. dla item, basket

    /**
     * Creates a new User entity.
     *
     * @Route("/createUser", name="customer_registration") 
     * @Template()
     */
    public function createUserAction(Request $req) {
        $repo = $this->getDoctrine()->getRepository('CodersLabShopBundle:User');
        $customer = new User();

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
     * @Route("/newUser", name = "customer_new")
     * @Template()
     */
    public function newUserAction() {
        $customer = new User();

        $form = $this->customerForm($customer);

        return [
            'form' => $form->createView()
        ];
    }

    private function updateUserForm($person) {

        $form = $this->createFormBuilder($person)
                ->add('username', 'text', ['label' => 'Login'])
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
     * @Route("/update/{id}", name = "customer_update")
     * @Method("GET")
     * @Template()
     */
    public function updateUserGetAction($id) {
        $repo = $this->getDoctrine()->getRepository('CodersLabShopBundle:User');

        $customer = $repo->find($id);
        if (!$customer) {
            return [
                'error' => 'Wystąpił błąd brak takiej osoby w bazie danych!'
            ];
        }
        $form = $this->updateUserForm($customer);
        return[
            'form' => $form->createView()
        ];
    }

    /**
     * @Route("/update/{id}", name = "updated_customer_save")
     * @Method("POST")
     * @Template()
     */
    public function updateUserPostAction(Request $req, $id) {
        $repo = $this->getDoctrine()->getRepository('CodersLabShopBundle:User');
        $customer = $repo->find($id);
        $form = $this->updateUserForm($customer, $customer->getId());
        $form->handleRequest($req);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();
        }
        return [
            'form' => $form->createView(),
            'success' => true
        ];
    }

}
