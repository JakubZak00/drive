<?php

namespace App\Controller;
use App\Entity\QueryDrive;
use App\Entity\User;
use App\Repository\QueryDriveRepository;
use Doctrine\ORM\EntityManagerInterface;
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
        $querys = $queryDriveRepository->findBy(array('id' => $random));
        foreach ($querys as $query)
        {
            return $this->render('exam/exam.html.twig', [
                'query' => $query,
            ]);
        }
    }
    #[Route('/quest', name: 'quest')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function quest(
        QueryDriveRepository $queryDriveRepository,
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response
    {
        $replay = $request->query->get('replay');
        $id = $request->query->get('id');
        $querys = $queryDriveRepository->findBy(array('id' => $id));
        foreach ($querys as $query)
        {

            if($replay){
                if($replay == ($query->getAnswer())){
                    $user = $this->getUser();
                    $user->setPoints();
                    $user->setMakeQuery();
                    $ratio = (($user->getPoints()) / ($user->getMakeQuery())) * 100;
                    $user->setRatio($ratio);
                    $entityManager->persist($user);
                    $entityManager->flush();
                    $this->addFlash('success', 'Prawidłowa odpowiedź');
                }else{
                    $user = $this->getUser();
                    $user->setMakeQuery();
                    $ratio = (($user->getPoints()) / ($user->getMakeQuery())) * 100;
                    $user->setRatio($ratio);
                    $entityManager->persist($user);
                    $entityManager->flush();
                    $this->addFlash('negative', 'Nieprawidłowa odpowiedź');
                }
            }
            return $this->render('exam/examAnswer.html.twig', [
                'query' => $query,
            ]);
        }

    }

}
