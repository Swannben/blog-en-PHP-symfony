<?php

namespace App\Controller\user;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    public function categoryList(): Response
    {
        return $this->render('category/category_summary.html.twig', [
            'Categories' => $this->getDoctrine()->getRepository(Category::class)->getCategorySummary()
        ]);
    }

}

?>