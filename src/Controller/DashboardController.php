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
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboard()
    {
        $db = new Database();
        $config = new \PHPAuth\Config($db->dbh);
        $auth = new \PHPAuth\Auth($db->dbh, $config);

        if (!$auth->isLogged()) {
            return $this->redirectToRoute('login');
        }

        return $this->render('dashboard/base.html.twig', [
            'title' => "dashboard",
        ]);
    }


}