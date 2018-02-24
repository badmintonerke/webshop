<?php
/**
 * Created by PhpStorm.
 * User: Nelis
 * Date: 23/02/2018
 * Time: 11:23
 */

namespace App\Controller;


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
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
            echo $user->use_role;
        } else {
            return $this->redirectToRoute('login', []);
        }

        return $this->render('dashboard/base.html.twig', [
            'title' => "dashboard",
        ]);
    }


}