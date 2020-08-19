<?php

namespace App\Controller;


use App\Entity\Registration;
use App\Entity\RegistrationFormType;
use App\Repository\MemberRepository;
use App\Repository\RegistrationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/mes-creneaux")
 * @IsGranted("ROLE_USER")
 */
class TimeSlotController extends AbstractController
{
    /**
     * @Route("/", name="app_slot", methods={"GET","POST"}))
     */
    public function index(MemberRepository $memberRepository, RegistrationRepository $registrationRepository, Request $request): Response
    {
        return $this->render('time_slot/index.html.twig', [
            'registrations' => $registrationRepository->findByDateAsc(),
            'members' => $memberRepository->findAll(),
        ]);
    }


    /**
     * @Route("/{id}", name="app_slot_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Registration $registration): Response
    {
        $this->denyAccessUnlessGranted('DELETE', $registration);

        if ($this->isCsrfTokenValid('delete'.$registration->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($registration);
            $entityManager->flush();

            $this->addFlash(
                'danger',
                'Le créneau a été supprimé'
            );
        }

        return $this->redirectToRoute('app_slot');
    }
}
