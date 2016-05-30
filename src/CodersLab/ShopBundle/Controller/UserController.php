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
     * @Route("/new/{id}")
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

            return new Response ('admin dodany');
        }
    }

    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction() {
        return [];
    }

    /**
     * @Route("/delete/{id}", name = "customer_delete")
     * 
     */
    public function deleteCustomerAction($id) {

        $loggedUser = $this->getUser();
        if ($loggedUser->hasRole('ROLE_ADMIN')) {

            $repo = $this->getDoctrine()->getRepository('CodersLabShopBundle:Customer');
            $em = $this->getDoctrine()->getManager();
            $deletedCustomer = $repo->find($id);
            if ($deletedCustomer) {
                $em->remove($deletedCustomer);
                $em->flush();
            }

            return new Response('uzytkownik usuniety');
        }

        return new Response('brak dostępu');
    }

}
