<?php
/**
 * Created by PhpStorm.
 * User: Nelis
 * Date: 23/02/2018
 * Time: 11:23
 */

namespace App\Controller;


use App\Entity\Database;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * Class DashboardController
 * @package App\Controller
 */
class DashboardController extends AbstractController
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
     * @Route("/dashboard", name="dashboard_home")
     */
    public function dashboard()
    {

        if (!$this->auth->isLogged()) {
            return $this->redirect($this->generateUrl('login',['redirectUrl' => 'dashboard_home' ]));
        }
        $uid = $this->auth->getSessionUID($_COOKIE[$this->config->cookie_name]);
        $user = $this->auth->getUser($uid);


        if ($user['email'] !== $this->config->admin_mail) {
            return false;
        }



        return $this->render('dashboard/home.html.twig', [
            'title' => "dashboard",
        ]);
    }


}