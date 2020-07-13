<?php

namespace App\Controller\admin;

use App\Entity\User;
use App\Form\EditUserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
     * @Route("/admin", name="admin_")
     * @IsGranted("ROLE_SUPER_ADMIN")
     */
class AdminController extends AbstractController
{
    /**
     * @Route("/utilisateurs", name="user")
     */
    public function index(UserRepository $users)
    {
        return $this->render('admin/account/index.html.twig', [
            'users' => $users->findAll(),
        ]);
    }

    /**
     * @Route("/utilisateur/modifier/{id}", name="user_edit")
     */
    public function editUserRole(User $user, Request $request)
    {
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_user');
        }

        return $this->render('admin/account/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);    }
}
