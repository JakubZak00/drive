<?php

namespace App\Controller;

use App\Repository\QueryDriveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    ): Response
    {
//        $cat=$queryDriveRepository->findByContains('T');
//        dd($cat);
        for ($i=1; $i<10; $i++){
            $random = random_int(1, 3694);
        }
        $query = $this->queryDriveRepository->findOneBy(array('id' => $random));
//        $cat = $query->getCategory();
//        $result = $this->$cat->containsAny('B');
//        dd($result);
        return $this->render('exam/exam.html.twig', [
            'query' => $query,
        ]);
    }
}
