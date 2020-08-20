<?php

namespace App\Controller;

use App\Entity\OnlineForm;
use App\Form\OnlineFormType;
use App\Repository\OnlineFormRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/online/form")
 */
class OnlineFormController extends AbstractController
{
    /**
     * @Route("/", name="online_form_index", methods={"GET"})
     */
    public function index(OnlineFormRepository $onlineFormRepository): Response
    {
        return $this->render('online_form/index.html.twig', [
            'online_forms' => $onlineFormRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="online_form_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $onlineForm = new OnlineForm();
        $form = $this->createForm(OnlineFormType::class, $onlineForm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($onlineForm);
            $entityManager->flush();

            return $this->redirectToRoute('app_document');
        }

        return $this->render('online_form/new.html.twig', [
            'online_form' => $onlineForm,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="online_form_show", methods={"GET"})
     */
    public function show(OnlineForm $onlineForm): Response
    {
        return $this->render('online_form/show.html.twig', [
            'online_form' => $onlineForm,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="online_form_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, OnlineForm $onlineForm): Response
    {
        $form = $this->createForm(OnlineFormType::class, $onlineForm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('online_form_index');
        }

        return $this->render('online_form/edit.html.twig', [
            'online_form' => $onlineForm,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="online_form_delete", methods={"DELETE"})
     */
    public function delete(Request $request, OnlineForm $onlineForm): Response
    {
        if ($this->isCsrfTokenValid('delete'.$onlineForm->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($onlineForm);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_document');
    }
}
