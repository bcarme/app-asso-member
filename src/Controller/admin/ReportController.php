<?php

namespace App\Controller\admin;

use App\Entity\Report;
use App\Form\ReportType;
use App\Repository\ReportRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/compte-rendu")
 */
class ReportController extends AbstractController
{
    /**
     * @Route("/index", name="report_index", methods={"GET"})
     */
    public function index(ReportRepository $reportRepository): Response
    {
        return $this->render('admin/report/index.html.twig', [
            'reports' => $reportRepository->findAll(),
        ]);
    }

    /**
     * @Route("/ajouter", name="report_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $report = new Report();
        $form = $this->createForm(ReportType::class, $report);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($report);
            $entityManager->flush();

            return $this->redirectToRoute('report_index');
        }

        return $this->render('admin/report/new.html.twig', [
            'report' => $report,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="report_show", methods={"GET"})
     */
    public function show(Report $report): Response
    {
        return $this->render('admin/report/show.html.twig', [
            'report' => $report,
        ]);
    }

    /**
     * @Route("/{id}", name="report_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Report $report): Response
    {
        if ($this->isCsrfTokenValid('delete'.$report->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($report);
            $entityManager->flush();
        }

        return $this->redirectToRoute('report_index');
    }
}
