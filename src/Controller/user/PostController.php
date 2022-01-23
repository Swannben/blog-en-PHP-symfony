<?php

namespace App\Controller\user;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/")
     *
     */
    public function index(): Response
    {
        return $this->render('home/home.html.twig');
    }

    /**
     * @Route("/post/{slug}")
     * @param string $slug 
     */
    public function post(string $slug): Response
    {
        return $this->render('post/post.html.twig',[
            'slug' => $slug,
        ]);
    }

}

?>