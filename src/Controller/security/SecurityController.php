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
    private $db;
    private $config;
    private $auth;

    public function __construct()
    {
        $this->db = new Database();
        $this->config = new \PHPAuth\Config($this->db->dbh);
        $this->auth = new \PHPAuth\Auth($this->db->dbh, $this->config);
    }

    /**
     * @Route("/login", name="login",methods={"GET"})
     */
    public function login(Request $request)
    {

        $redirectUrl = $request->query->get("redirectUrl");
        if ($this->auth->isLogged()) {
            return $this->redirectToRoute('homepage');
        }

        return $this->render('security/login.html.twig', [
            'title' => 'ac-sport',
            'error' => '',
            'form_error' => '',
            'form_redirectTo' => $redirectUrl,
        ]);
    }

    /**
     * @Route("/login", name="login_check", methods={"POST"})
     */
    public function loginCheck(Request $request)
    {
        $redirectUrl = $request->request->get("redirectUrl");

        $name = $request->request->get("name");
        $password = $request->request->get("password");
        $remember = intval($request->request->get("remember-me") ?? 0);
        $formError = $this->auth->login($name, $password, $remember);

        if ($this->auth->isLogged()) {
            if ($redirectUrl)
                return $this->redirectToRoute($redirectUrl);

            return $this->redirectToRoute('homepage');
        }

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

        $name = $request->request->get("name");
        $password = $request->request->get("password");
        $password2 = $request->request->get("password2");

        $formError = $this->auth->register($name, $password, $password2);

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
        $hash = $this->auth->getSessionHash();
        $this->auth->logout($hash);

        return $this->redirectToRoute('login');
    }
}