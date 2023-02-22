<?php

namespace App\Controller;

use App\Repository\QueryDriveRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ExamAnswerController extends AbstractController
{
    #[Route('/answer', name: 'examAnswer')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function examAnswer(
        QueryDriveRepository $queryDriveRepository,
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response
    {
        $replay = $request->query->get('replay');
        $id = $request->query->get('id');
        $query = $queryDriveRepository->findOneBy(array('id' => $id));
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
