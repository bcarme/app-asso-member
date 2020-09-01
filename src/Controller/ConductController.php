<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Conduct;
use App\Form\ConductType;
use App\Repository\ConductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/charte")
 * @IsGranted("ROLE_USER")
 */
class ConductController extends AbstractController
{
    /**
     * @Route("/", name="conduct_index", methods={"GET"})
     */
    public function index(ConductRepository $conductRepository): Response
    {
        return $this->render('conduct/index.html.twig', [
            'conducts' => $conductRepository->findAll(),
        ]);
    }

    /**
     * @Route("/completer", name="conduct_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $conduct = new Conduct();
        $form = $this->createForm(ConductType::class, $conduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $conduct->setUser($this->getUser());
            $entityManager->persist($conduct);
            $entityManager->flush();

            return $this->redirectToRoute('conduct_index');
        }

        return $this->render('conduct/new.html.twig', [
            'conduct' => $conduct,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/pdf/{id}", name="conduct_show", methods={"GET"})
     */
    public function show(Conduct $conduct)
    {
        $this->denyAccessUnlessGranted('SHOW', $conduct);

        $pdfOptions = new Options();
        $pdfOptions->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($pdfOptions);
        $html = $this->renderView('conduct/show.html.twig', [
            'conduct' => $conduct,
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("charte_bonne_conduite.pdf", [
            "Attachment" => false
        ]);
    }

    /**
     * @Route("/{id}/edit", name="conduct_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Conduct $conduct): Response
    {
        $form = $this->createForm(ConductType::class, $conduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('conduct_index');
        }

        return $this->render('conduct/edit.html.twig', [
            'conduct' => $conduct,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="conduct_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Conduct $conduct): Response
    {
        $this->denyAccessUnlessGranted('DELETE', $conduct);

        if ($this->isCsrfTokenValid('delete'.$conduct->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($conduct);
            $entityManager->flush();
        }

        return $this->redirectToRoute('conduct_index');
    }
}
