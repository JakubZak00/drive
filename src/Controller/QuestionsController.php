<?php

namespace App\Controller;

use App\Entity\File;
use App\Entity\QueryDrive;
use App\Form\FileUploadType;
use App\Repository\FileRepository;
use App\Repository\QueryDriveRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use PhpOffice\PhpSpreadsheet\IOFactory;

#[AsController]
class QuestionsController extends AbstractController
{
    #[Route('/upload-excel', name: 'xlsx')]
    public function xslx(
        Request $request,
        FileRepository $fileRepository,
        EntityManagerInterface $entityManager,
    ): Response
    {
        $excel = new File();
        $form = $this->createForm(FileUploadType::class, $excel);
        $form->handleRequest($request);
        $fileFolder = $this->getParameter('query_directory');

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('name')->getData();
            if ($file) {
                $filePathName = md5(uniqid()) . $file->getClientOriginalName();
                try {
                    $file->move($fileFolder, $filePathName);
                } catch (FileException $e) {
                    dd($e);
                }
                $excel->setName($filePathName);
                $spreadsheet = IOFactory::load($fileFolder . $filePathName); // Here we are able to read from the excel file
                $row = $spreadsheet->getActiveSheet()->removeRow(1); // I added this to be able to remove the first file line
                $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true); // here, the read data is turned into an array
                $fileRepository->save($excel, true);

                foreach ($sheetData as $row) {
                    $NumberQuery = $row['B'];
                    $Query = $row['C'];
                    $A = $row['D'];
                    $B = $row['E'];
                    $C = $row['F'];
                    $answer = $row['O'];
                    $points = $row['R'];
                    $category = $row['S'];

                    $query_existant = $entityManager->getRepository(QueryDrive::class)->findOneBy(array('NumberQuery' => $NumberQuery));
                    if (!$query_existant) {
                        $queryDrive = new QueryDrive();
                        $queryDrive->setNumberQuery($NumberQuery);
                        $queryDrive->setQuery($Query);
                        $queryDrive->setA($A);
                        $queryDrive->setB($B);
                        $queryDrive->setC($C);
                        $queryDrive->setAnswer($answer);
                        $queryDrive->setPoints($points);
                        $queryDrive->setCategory($category);
                        $entityManager->persist($queryDrive);
                        $entityManager->flush();
                    }
                }
                return $this->json('users registered', 200);
            }
        }

        return $this->render(
            'questions/index.html.twig',
            [
                'form' => $form->createView(),
            ]
        );

    }
}
