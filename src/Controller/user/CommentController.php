<?php

namespace App\Controller\user;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{

    public function recentComment(): Response
    {
        $comment = $this->getDoctrine()->getRepository(Comment::class)->findBy(array('valid' => true), array('createdAt' => 'DESC'), 5);
        return $this->render('comment/comment.recent.html.twig', [
            'comments' => $comment
        ]);
    }

}

?>