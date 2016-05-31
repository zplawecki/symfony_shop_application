<?php

namespace CodersLab\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\UserBundle\Doctrine\UserManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Doctrine\Common\Collections\ArrayCollection;

class UserController extends Controller {

    private function updateUserForm($person) {

        $form = $this->createFormBuilder($person)
//            ->setAction($this->generateUrl('user_update'))
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
     * @Route("/panel", name="panel")
     * @Template()
     */
    public function showAdminPanelAction() {

        return [
        ];
    }

    /**
     * @Route("/main")
     */
    public function redirectToAction() {
        $loggedUser = $this->getUser();
        if ($loggedUser->hasRole('ROLE_ADMIN')) {
            return $this->redirectToRoute('panel');
        } else {
            return $this->redirectToRoute('all_items');
        }
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

            return [
                'allUsers' => $allUsers
            ];
        }
    }

    /**
     * @Route("/update/{id}", name = "user_update")
     * @Method("GET")
     * @Template()
     */
    public function updateUserGetAction($id) {
        $repo = $this->getDoctrine()->getRepository('CodersLabShopBundle:User');

        $user = $repo->find($id);
        if (!$user) {
            return [
                'error' => 'Wystąpił błąd brak takiej osoby w bazie danych!'
            ];
        }
        $form = $this->updateUserForm($user);
        return[
            'form' => $form->createView()
        ];
    }

    /**
     * @Route("/update/{id}", name = "updated_user_save")
     * @Method("POST")
     * @Template()
     */
    public function updateUserPostAction(Request $req, $id) {
        $repo = $this->getDoctrine()->getRepository('CodersLabShopBundle:User');
        $user = $repo->find($id);
        $form = $this->updateUserForm($user, $user->getId());
        $form->handleRequest($req);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }
        return [
            'form' => $form->createView(),
            'success' => true
        ];
    }

}
