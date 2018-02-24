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
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        unset($_SESSION['user']);
    }

    /**
     * @Route("/login", name="login_check", methods={"POST"})
     */
    public function loginCheck(Request $request)
    {
        $name = $request->request->get("name");
        $password = $request->request->get("password");

        $db = new Database();
        $db->query("SELECT * FROM symfony_shop.users WHERE use_name = :userName");
        $db->bind(':userName', $name);
        $user = $db->single();
        if ($password == $user->use_password) {
            echo 'auth';
            $_SESSION['user'] = $user;
        }

        return $this->render('security/login.html.twig', [
            'title' => 'ac-sport',
            'error' => $name . ' ' . $password,
        ]);
    }
}