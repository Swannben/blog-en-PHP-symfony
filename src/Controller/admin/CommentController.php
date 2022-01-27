<?php

namespace App\Controller\admin;

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
    /**
     * @Route("/admin/comments", name="admin_comment_index", methods={"GET"})
     * 
     */
    public function index(CommentRepository $commentRepository): Response
    {
        return $this->render('comment/index.html.twig', [
            'comments' => $commentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/comments/valid/{id}", name="admin_comment_valid")
     * @param int $id
     * @return Response
     */
    public function valid(int $id): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $commment = $manager->getRepository(Comment::class)->find($id);
        if ($commment === null) {
            throw $this->createNotFoundException("Comment not found");
        }

        $commment->setValid(true);
        $manager->flush();
        return $this->redirectToRoute('admin_comment_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("/admin/comments/delete/{id}", name="admin_comment_delete")
     * @param int $id
     * @return Response
     */
    public function delete(int $id): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $comm = $manager->getRepository(Comment::class)->find($id);
        if (!$comm) {
            throw $this->createNotFoundException("Comment not found");
        }
        $manager->remove($comm);
        $manager->flush();
        return $this->redirectToRoute('admin_comment_index');
    }

    public function recentComment(): Response
    {
        $comment = $this->getDoctrine()->getRepository(Comment::class)->findBy(array('valid' => true), array('createdAt' => 'DESC'), 5);
        return $this->render('comment/recent_comment.html.twig', [
            'comments' => $comment
        ]);
    }


    

}

?>