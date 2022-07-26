<?php

namespace App\Controller;

use App\Form\ExportFormType;
use App\Repository\IconographiqueRepository;
use App\Repository\PigisteClientRepository;
use App\Repository\RedachefRepository;
use DateTime;
use DateTimeZone;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;

class ExporterController extends AbstractController
{
    protected function createSpreadsheet($columnNames, $columnValues)
    {
        $spreadsheet = new Spreadsheet();
        // Get active sheet - it is also possible to retrieve a specific sheet
        $sheet = $spreadsheet->getActiveSheet();

        $columnLetter = 'A';
        foreach ($columnNames as $columnName) {
            // Allow to access AA column if needed and more
            $sheet->setCellValue($columnLetter . '1', $columnName);
            $columnLetter++;
        }

        $i = 2; // Beginning row for active sheet
        foreach ($columnValues as $columnValue) {
            $columnLetter = 'A';
            foreach ($columnValue as $value) {
                $sheet->setCellValue($columnLetter . $i, $value);
                $columnLetter++;
            }
            $i++;
        }

        return $spreadsheet;
    }

    #[Route('/export', name: 'export')]
    public function exportAction(Request $request, IconographiqueRepository $iconographiqueRepository, RedachefRepository $redachefRepository, PigisteClientRepository $pigisteClientRepository)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(ExportFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $type = $data['type'];

            switch ($type) {
                case ExportFormType::ICONOGRAPHIE_KEY:
                    $repository = $iconographiqueRepository;
                    $name = 'iconographique';
                    $columnKeys = ["Code Affaire", "Nom d'usage", "Article", "Nb photo", "Prix photo", "Montant"];

                    break;
                case ExportFormType::REDACHEF_KEY:
                    $repository = $redachefRepository;
                    $name = 'redachef';
                    $columnKeys = ["Code Affaire", "Nom d'usage", "Article", "signe", "Nb de feuillet", "Forfait", "Prix au feuillet", "Montant", "Montant total brut", "Montant charge"];

                    break;
                case ExportFormType::PIGISTE_KEY:
                    $repository = $pigisteClientRepository;
                    $name = 'pigiste_client';
                    $columnKeys = ["Code Affaire", "Nom d'usage", "Article", "signe", "Nb de feuillet", "Forfait", "Prix au feuillet", "Montant", "Montant total brut", "Montant charge"];

                    break;
                default:
                    return $this->render('export/index.html.twig', [
                        'form' => $form->createView(),
                    ]);
            }

            $dt = new DateTime();
            $dt->setTimezone(new DateTimeZone('Europe/Paris'));

            $filename = $name . '_' . $dt->format('d_m_Y__H_i_s') . '.xlsx';

            $spreadsheet = $this->createSpreadsheet(
                $columnKeys,
                $repository->getForExport()
            );

            $contentType = 'text/xlsx';
            $writer = new Xlsx($spreadsheet);

            $response = new StreamedResponse();
            $response->headers->set('Content-Type', $contentType);
            $response->headers->set('Content-Disposition', 'attachment;filename="' . $filename . '"');
            $response->setPrivate();
            $response->headers->addCacheControlDirective('no-cache', true);
            $response->headers->addCacheControlDirective('must-revalidate', true);
            $response->setCallback(function () use ($writer) {
                $writer->save('php://output');
            });

            return $response;
        }

        return $this->render('export/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}