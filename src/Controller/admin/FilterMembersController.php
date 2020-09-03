<?php

namespace App\Controller\admin;

use App\Entity\Member;
use App\Form\MemberType;
use App\Repository\MemberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/adherents")
 */
class FilterMembersController extends AbstractController
{
    /**
     * @Route("/", name="admin_members", methods={"GET"})
     */
    public function index(memberRepository $memberRepository): Response
    {
        return $this->render('admin/filterMembers/index.html.twig', [
            'members' => $memberRepository->findAllMembers(),
        ]);
    }

}
