<?php
namespace App\Service;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VerificationAnswer extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ){
    }
    public function verficiation($replay, $query, $user): void
    {
        if($replay == ($query->getAnswer())){
            $user->setPoints();
            $user->setMakeQuery();
            $ratio = (($user->getPoints()) / ($user->getMakeQuery())) * 100;
            $user->setRatio($ratio);
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $this->addFlash('success', 'Prawidłowa odpowiedź');
        }else{
            $user->setMakeQuery();
            $ratio = (($user->getPoints()) / ($user->getMakeQuery())) * 100;
            $user->setRatio($ratio);
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $this->addFlash('negative', 'Nieprawidłowa odpowiedź');
        }
    }
}