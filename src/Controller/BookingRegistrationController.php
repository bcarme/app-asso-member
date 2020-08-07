<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Registration;
use App\Form\BookingRegistrationType;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/reservation", name="booking_registration_")
 * @IsGranted("ROLE_USER")
 */

class BookingRegistrationController extends AbstractController
{
    /**
     * sert de test
     * à supprimer quand on fera la modal dans le calendar
     * 
     * @Route("/index", name="index")
     */
    public function index(BookingRepository $bookingRepository): Response
    {
        return $this->render('booking_registration/index.html.twig', [
            'bookings' => $bookingRepository->findAll(),
        ]);
    }

    /**
     * sera utilisé pour la modal dans le calendar
     * 
     * @Route("/{id}/sinscrire", name="register", methods={"GET", "POST"})
     */
    public function register(Booking $booking, Request $request, EntityManagerInterface $em)
    {

        $registration = new Registration();

        $form = $this->createForm(BookingRegistrationType::class, $registration);

        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) {
            $registration->setBooking($booking);
            $registration->setUser($this->getUser());
            // $registration->setMember($this->getUser());

            $em->persist($registration);
            $em->flush();

            // $this->addFlash('success', 'Merci pour votre inscription !');

            return $this->redirectToRoute('app_calendar');
        }

        return $this->render('booking_registration/register.html.twig', [
            'booking' => $booking,
            'form' => $form->createView()
        ]);
    }
}
