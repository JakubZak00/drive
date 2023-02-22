<?php

namespace App\Controller;

use App\Repository\QueryDriveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ExamController extends AbstractController
{
    #[Route('/exam', name: 'exam')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function Exam(
        QueryDriveRepository $queryDriveRepository,
        Request $request,
    ): Response
    {
        for ($i=1; $i<10; $i++){
            $random = random_int(1, 3694);
        }
        $query = $queryDriveRepository->findOneBy(array('id' => $random));

        return $this->render('exam/exam.html.twig', [
            'query' => $query,
        ]);
    }
}
