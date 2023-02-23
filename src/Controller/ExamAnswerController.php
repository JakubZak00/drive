<?php

namespace App\Controller;

use App\Repository\QueryDriveRepository;
use App\Service\VerificationAnswer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExamAnswerController extends AbstractController
{
    public function __construct(
        private QueryDriveRepository $queryDriveRepository,
    ){
    }
    #[Route('/answer', name: 'examAnswer')]
    public function examAnswer(
        Request $request,
        VerificationAnswer $verificationAnswer,
    ): Response
    {
        $replay = $request->query->get('replay');
        $id = $request->query->get('id');
        $query = $this->queryDriveRepository->findOneBy(array('id' => $id));
        $user = $this->getUser();
        if($replay){
            $verificationAnswer->verficiation($replay, $query, $user);
        }

        return $this->render('exam/examAnswer.html.twig', [
            'query' => $query,
        ]);
    }
}
