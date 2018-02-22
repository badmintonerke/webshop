<?php
/**
 * Created by PhpStorm.
 * User: Nelis
 * Date: 21/02/2018
 * Time: 13:11
 */

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepage()
    {
        return $this->render('article/homepage.html.twig');
    }

    /**
     * @Route("/news/{slug}",name="article_show")
     */
    public function show($slug)
    {
        $comments = [
            'jdsiezurkdsjf iqsdjf ksjdfaif sdfifkajf',
            'jdsiezurkdsjf dsdfqsfqsfiqsdjf ksjdfaifsqdfds sdfifkajf',
            'jdsiezurkdsffsdfdsjf qsdfsqiqsdjqdsf dfksjdsdfsdfqsfaif sdfifkajf'
        ];


        return $this->render('article/show.html.twig', [
            'title' => ucwords(str_replace('-', ' ', $slug)),
            'slug' => $slug,
            'comments' => $comments,
        ]);
    }

    /**
     * @Route("/news/{slug}/heart", name="article_toggle_heart" , methods={"POST"})
     */
    public function toggleArticleHeart($slug)
    {
        //TODO - db

        return new JsonResponse(['hearts' => rand(5,100)]);

    }
}