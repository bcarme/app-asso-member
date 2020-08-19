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
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

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
     * 
     * @Route("/{id}/sinscrire", name="register", methods={"GET", "POST"})
     * @param Request $request
     * @param MailerInterface $mailer
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function register(Booking $booking, EntityManagerInterface $em,  Request $request,
    MailerInterface $mailer): Response
    {

        $registration = new Registration();
        $form = $this->createForm(BookingRegistrationType::class, $registration);
        $form->handleRequest($request);

        try {
            if ($form->isSubmitted() && $form->isValid()) {
                $registration->setBooking($booking);
                $registration->setUser($this->getUser());
                $em->persist($registration);
                $em->flush();
                
                $email = (new Email())
                ->from($this->getParameter('mailer_from'))
                ->to($form->get('email')->getData())
                ->subject('Vous avez reçu un nouveau message du club.')
                ->html($this->renderView('emails/_timeslot.html.twig', [
                    'registration' => $registration
                ]));
                $mailer->send($email);
                $this->addFlash('success', 'Un email de confirmation vous a été envoyé');

                return $this->redirectToRoute('app_calendar');
            }
        } catch (UniqueConstraintViolationException $e) {
            $this->addFlash("error", "Erreur : Vous avez déjà réservé ce créneau");
        }

        return $this->render('booking_registration/register.html.twig', [
            'booking' => $booking,
            'form' => $form->createView()
        ]);
    }
}
