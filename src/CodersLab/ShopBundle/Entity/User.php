<?php

namespace CodersLab\CodersBookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\UserBundle\Doctrine\UserManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DefaultController extends Controller {

    /**
     * @Route("/new/admin")
     * @Method ("POST")
     * @Template()
     */
    public function createAdminAction(Request $req) {
        $userManager = $this->get('fos_user.user_manager');
        $admin = $userManager->createUser();
        $password = $req->request->get('password');
        $email = $req->request->get('mail');

        if ($userManager->findUserByEmail($email)) {
            return new Response('This email already exists');
        }

        $admin->setEmail($email);
        $admin->setPlainPassword($password);
        $admin->setEnabled(true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($admin);
        $em->flush();

        return [
            'admin' => $admin
        ];
    }

    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction() {
        return [];
    }

}
?>

