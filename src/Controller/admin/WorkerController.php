<?php

namespace App\Controller\admin;

use App\Entity\Member;
use App\Form\MemberWorkerType;
use App\Repository\MemberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/collaborateurs")
 */
class WorkerController extends AbstractController
{
    /**
     * @Route("/", name="worker_index", methods={"GET"})
     */
    public function index(memberRepository $memberRepository): Response
    {
        return $this->render('admin/worker/index.html.twig', [
            'workers' => $memberRepository->findAllWorkers(),
        ]);
    }

    /**
     * @Route("/ajouter", name="worker_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $worker = new Member();
        $form = $this->createForm(MemberWorkerType::class, $worker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($worker);
            $entityManager->flush();

            return $this->redirectToRoute('worker_index');
        }

        return $this->render('admin/worker/new.html.twig', [
            'worker' => $worker,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="worker_show", methods={"GET"})
     */
    public function show(Member $worker): Response
    {
        return $this->render('admin/worker/show.html.twig', [
            'worker' => $worker,
        ]);
    }

    /**
     * @Route("/{id}/editer", name="worker_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Member $worker): Response
    {
        $form = $this->createForm(MemberWorkerType::class, $worker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('worker_index');
        }

        return $this->render('admin/worker/edit.html.twig', [
            'worker' => $worker,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="worker_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Member $worker): Response
    {
        if ($this->isCsrfTokenValid('delete'.$worker->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($worker);
            $entityManager->flush();
        }

        return $this->redirectToRoute('worker_index');
    }
}
