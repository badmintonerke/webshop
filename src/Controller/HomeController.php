<?php
/**
 * Created by PhpStorm.
 * User: Nelis
 * Date: 22/02/2018
 * Time: 15:13
 */

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="homepage")
     */
    public function homepage()
    {
        return $this->render('article/homepage.html.twig', [
            'title' => "ac-sport",
        ]);
    }


}