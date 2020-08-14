<?php

namespace App\Controller;

use App\Entity\Document;
use App\Form\DocumentType;
use App\Repository\MemberRepository;
use App\Repository\DocumentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/document")
 * @IsGranted("ROLE_USER")
 */
class DocumentController extends AbstractController
{
    /**
     * @Route("/", name="app_document", methods={"GET","POST"})
     */
    public function index(MemberRepository $memberRepository, DocumentRepository $documentRepository, Request $request): Response
    {
        $document = new Document();
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $document->setUser($this->getUser());
            $entityManager->persist($document);
            $entityManager->flush();

            return $this->redirectToRoute('app_document');
        }

        return $this->render('document/index.html.twig', [
            'documents' => $documentRepository->findAll(),
            'document' => $document,
            'form' => $form->createView(),
            'members' => $memberRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="document_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Document $document): Response
    {
        $this->denyAccessUnlessGranted('DELETE', $document);

        if ($this->isCsrfTokenValid('delete'.$document->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($document);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_document');
    }
}
