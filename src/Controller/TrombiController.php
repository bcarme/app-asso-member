<?php

namespace App\Controller;

use App\Entity\Member;
use App\Repository\MemberRepository;
use App\Form\TrombiSearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class TrombiController extends AbstractController
{
    /**
     * @Route("/trombinoscope", name="app_trombi")
     * @return Response
     */
    public function index(MemberRepository $memberRepository, Request $request, PaginatorInterface $paginator):Response
    {
        $members = $this->getDoctrine()
        ->getRepository(Member::class)
        ->findAll();

    $form = $this->createForm(TrombiSearchType::class);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $data = $form->getData();
        $search = $data['search'];
        $members =  $memberRepository->findByName($search);
    }


    $members = $paginator->paginate(
        $members, // Requête contenant les données à paginer (ici nos articles)
        $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
        10// Nombre de résultats par page
    );
    return $this->render('trombi/index.html.twig', [
        'members' => $members,
        'form' => $form->createView(),
    ]);
  }
}