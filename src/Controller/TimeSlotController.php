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
     * @Route("/export/creneaux", name="slot_export", methods={"GET"})
     * @param MemberRepository $memberRepository
     * @param RegistrationRepository $registrationRepository
     * @return Response
     */
    public function exportTimeSlots(MemberRepository $memberRepository, RegistrationRepository $registrationRepository): Response
    {
        $csv = $this->renderView('time_slot/export_slots.csv.twig', [
            'registrations' => $registrationRepository->findByDateAsc(),
            'members' => $memberRepository->findAll(),
        ]);

        $response = new Response($csv);
        $response->setStatusCode(200);

        $response->headers->set('Content-Type', 'application/csv;charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="export_creneaux.csv"');

        return $response;
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
