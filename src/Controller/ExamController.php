<?php

namespace App\Controller;

use App\Repository\QueryDriveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ExamController extends AbstractController
{

    public function __construct(
       private QueryDriveRepository $queryDriveRepository,
    ){
    }
    #[Route('/exam', name: 'exam')]
    public function Exam(
        Request $request
    ): Response
    {
        $category = $request->query->get('cat');
        $categoryQuery=$this->queryDriveRepository->findByContainsCategory($category);
        $random = array_rand($categoryQuery, $num =1);
        $query = $categoryQuery[$random];


        return $this->render('exam/exam.html.twig', [
            'query' => $query,
        ]);
    }
}
