<?php
/**
 * Created by PhpStorm.
 * User: Nelis
 * Date: 23/02/2018
 * Time: 12:40
 */

namespace App\Controller\security;


use App\Entity\Database;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login",methods={"GET"})
     */
    public function login($error = '')
    {
        $error = 'sdfq0';

        return $this->render('security/login.html.twig', [
            'title' => 'ac-sport',
            'error' => $error,
            'form_error' => '',
        ]);
    }

    /**
     * @Route("/login", name="login_check", methods={"POST"})
     */
    public function loginCheck(Request $request)
    {

        $db = new Database();
        $config = new \PHPAuth\Config($db->dbh);
        $auth = new \PHPAuth\Auth($db->dbh, $config);

        $name = $request->request->get("name");
        $password = $request->request->get("password");
        $remember = intval($request->request->get("remember-me") ?? 0);
        $formError = $auth->login($name, $password, $remember);

        return $this->render('security/login.html.twig', [
            'title' => 'ac-sport',
            'error' => $name . ' ' . $password,
            'form_error' => $formError['message'],
        ]);
    }

    /**
     * @Route("/register",name="register_vieuw" , methods={"GET"})
     */
    public function register()
    {
        $error = 'register controller';

        return $this->render('security/register.html.twig', [
            'title' => 'ac-sport',
            'error' => $error,
            'form_error' => '',
        ]);
    }

    /**
     * @Route("/register",name="register_handler" , methods={"POST"})
     */
    public function register_handler(Request $request)
    {
        $error = 'register controller handler';

        $db = new Database();
        $config = new \PHPAuth\Config($db->dbh);
        $auth = new \PHPAuth\Auth($db->dbh, $config);

        $name = $request->request->get("name");
        $password = $request->request->get("password");
        $password2 = $request->request->get("password2");

        $formError = $auth->register($name, $password, $password2);

        return $this->render('security/register.html.twig', [
            'title' => 'ac-sport',
            'error' => $error,
            'form_error' => $formError['message'],
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        $db = new Database();
        $config = new \PHPAuth\Config($db->dbh);
        $auth = new \PHPAuth\Auth($db->dbh, $config);
        $hash = $auth->getSessionHash();
        $auth->logout($hash);
    }
}