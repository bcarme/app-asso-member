<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\OnlineForm;
use App\Form\OnlineFormType;
use App\Form\OnlineImageFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/formulaire")
 * @IsGranted("ROLE_USER")
 */
class OnlineFormController extends AbstractController
{
    /**
     * @Route("/creer/autorisation-parentale", name="online_form_new", methods={"GET","POST"})
     */
    public function newParentForm(Request $request): Response
    {
        $onlineForm = new OnlineForm();
        $form = $this->createForm(OnlineFormType::class, $onlineForm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $onlineForm->setUser($this->getUser());
            $entityManager->persist($onlineForm);
            $entityManager->flush();

            return $this->redirectToRoute('app_document');
        }

        return $this->render('online_form/new_parent.html.twig', [
            'online_form' => $onlineForm,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/creer/droit-image", name="online_form_image", methods={"GET","POST"})
     */
    public function newImageRight(Request $request): Response
    {
        $onlineForm = new OnlineForm();
        $form = $this->createForm(OnlineImageFormType::class, $onlineForm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $onlineForm->setUser($this->getUser());
            $entityManager->persist($onlineForm);
            $entityManager->flush();

            return $this->redirectToRoute('app_document');
        }

        return $this->render('online_form/new_image_right.html.twig', [
            'online_form' => $onlineForm,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/pdf/autorisation-parentale/{id}", name="online_form_pdf", methods={"GET"})
     */
    public function generatePdf(OnlineForm $onlineForm): Response
    {
        $pdfOptions = new Options();
        $pdfOptions->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($pdfOptions);
        $html = $this->renderView('online_form/pdf/parent_pdf.html.twig', [
            'online_form' => $onlineForm,
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("autorisation_parentale.pdf", [
            "Attachment" => false
        ]);

        return $this->render('online_form/show.html.twig', [
            'online_form' => $onlineForm,
        ]);
    }

    /**
     * @Route("/pdf/droit-image/{id}", name="image_form_pdf", methods={"GET"})
     */
    public function generateImagePdf(OnlineForm $onlineForm): Response
    {
        $pdfOptions = new Options();
        $pdfOptions->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($pdfOptions);
        $html = $this->renderView('online_form/pdf/image_right_pdf.html.twig', [
            'online_form' => $onlineForm,
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("droit image.pdf", [
            "Attachment" => false
        ]);

        return $this->render('online_form/show.html.twig', [
            'online_form' => $onlineForm,
        ]);
    }

    /**
     * @Route("/{id}", name="online_form_delete", methods={"DELETE"})
     */
    public function delete(Request $request, OnlineForm $onlineForm): Response
    {
        $this->denyAccessUnlessGranted('DELETE', $onlineForm);

        if ($this->isCsrfTokenValid('delete'.$onlineForm->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($onlineForm);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_document');
    }
}
