<?php

namespace App\Controller;

use App\Form\ExportFormType;
use App\Repository\IconographiqueRepository;
use App\Repository\MagazineRepository;
use App\Repository\PigisteClientRepository;
use App\Repository\RedachefRepository;
use App\Repository\SalarieEtEntrepriseRepository;
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

    protected function getDateParts($data, $key, $parts = []): array
    {
        if (isset($data[$key])) {
            $parts[] = $data[$key];
        } else {
            $parts[] = $key === 'year' ? '____' : '__';
        }

        return $parts;
    }

    #[Route('/export', name: 'export')]
    public function exportAction(Request $request, IconographiqueRepository $iconographiqueRepository, RedachefRepository $redachefRepository, PigisteClientRepository $pigisteClientRepository, MagazineRepository $magazineRepository, SalarieEtEntrepriseRepository $salarieEtEntrepriseRepository )
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(ExportFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $type = $data['type'];

            $dateParts = $this->getDateParts($data, 'day');
            $dateParts = $this->getDateParts($data, 'month', $dateParts);
            $dateParts = $this->getDateParts($data, 'year', $dateParts);

            $date = implode('/', $dateParts);

            // No date selected
            if ($date === '__/__/____') {
                $date = null;
            }

            switch ($type) {
                case ExportFormType::ICONOGRAPHIE_KEY:
                    $repository = $iconographiqueRepository;
                    $name = 'iconographie';
                    $columnKeys = ["Code Affaire", "Nom d'usage", "Date de parution", "Article", "Nb photo", "Prix photo", "Montant"];

                    break;
                case ExportFormType::REDACHEF_KEY:
                    $repository = $redachefRepository;
                    $name = 'redac_chef';
                    $columnKeys = ["Code Affaire", "Nom d'usage", "Date de parution", "Article", "signe", "Nb de feuillet", "Forfait", "Prix au feuillet", "Montant", "Montant total brut", "Montant charge"];

                    break;
                case ExportFormType::PIGISTE_KEY:
                    $repository = $pigisteClientRepository;
                    $name = 'pigiste_client';
                    $columnKeys = ["Code Affaire", "Nom d'usage", "Date de parution", "Article", "signe", "Nb de feuillet", "Forfait", "Prix au feuillet", "Montant", "Montant total brut", "Montant charge"];

                    break;
                case ExportFormType::MAGAZINE_KEY:
                    $repository = $magazineRepository;
                    $name = 'magazine';
                    $columnKeys = ["Code Affaire", "Code affaire en clair","Date de bouclage", "Date de parution", "Titre en clair", "Nb de page redactionnelle", "Chiffre affaire"];

                    break;
                case ExportFormType::SALARIEENTREPRISE_KEY:
                    $repository = $salarieEtEntrepriseRepository;
                    $name = 'salarie_et_entreprise';
                    $columnKeys = ["Nom d'usage", "Nom compta", "Statut", "Type", "Droit auteur", "Abattement 30%", "Ratio brut commandé"];

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
                $repository->getForExport($date)
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