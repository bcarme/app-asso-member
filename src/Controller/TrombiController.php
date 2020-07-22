<?php

namespace App\Controller;

use App\Entity\Member;
use App\Repository\MemberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TrombiController extends AbstractController
{
    /**
     * @Route("/trombinoscope", name="app_trombi")
     */
    public function index(MemberRepository $memberRepository)
    {
          return $this->render('trombi/index.html.twig', [
            'members'=>$memberRepository->findAllInAscOrder(),
        ]);
    }
}
