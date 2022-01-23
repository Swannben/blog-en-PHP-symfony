<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalculController extends AbstractController
{
    /**
     * @Route("/add/{nb1}/{nb2}", name="add", requirements={"nb1"="\d+", "nb2"="\d+"})
     */
    public function add(int $nb1, int $nb2): Response
    {
        return new Response("$nb1 + $nb2 = " . ($nb1 + $nb2));
    }

    /**
     * @Route("/squared/{nb1}", name="squared", requirements={"nb1"="\d+"})
     */
    public function squared(int $nb1): Response
    {
        return new Response($nb1."² = ". $nb1 * $nb1);
    }
}

?>