<?php

namespace App\Controller;
use App\Entity\QueryDrive;
use App\Repository\QueryDriveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ExamController extends AbstractController
{
    #[Route('/exam', name: 'exam')]
    public function Exam(
        QueryDriveRepository $queryDriveRepository,
        Request $request,
    ): Response
    {
        for ($i=1; $i<10; $i++){
            $random = random_int(1, 3694);
        }
        $querys = $queryDriveRepository->findBy(array('id' => $random));
        foreach ($querys as $query)
        {
            return $this->render('exam/exam.html.twig', [
                'query' => $query,
            ]);
        }
    }
    #[Route('/quest', name: 'quest')]
    public function quest(
        QueryDriveRepository $queryDriveRepository,
        Request $request,
    ): Response
    {
        $replay = $request->query->get('replay');
        $id = $request->query->get('id');
        $querys = $queryDriveRepository->findBy(array('id' => $id));
        foreach ($querys as $query)
        {

            if($replay){
                if($replay == ($query->getAnswer())){
                    $this->addFlash('success', 'Prawidłowa odpowiedź');
                }else{
                    $this->addFlash('negative', 'Nieprawidłowa odpowiedź');
                }
            }
            return $this->render('exam/examAnswer.html.twig', [
                'query' => $query,
            ]);
        }

    }

}
