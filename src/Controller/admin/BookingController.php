<?php

namespace App\Controller\admin;

use App\Entity\Booking;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

/**
 * @Route("admin/planning")
 */
class BookingController extends AbstractController
{
    
    /**
     * @Route("/index", name="booking_index", methods={"GET"})
     */
    public function index(BookingRepository $bookingRepository): Response
    {
        return $this->render('admin/booking/index.html.twig', [
            'bookings' => $bookingRepository->findByDateAsc(),
        ]);
    }

    /**
     * @Route("/ajouter", name="booking_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($booking);
            $entityManager->flush();

            $this->addFlash('success', 'L\'évenement a bien été créé');

            return $this->redirectToRoute('booking_index');

        }

        return $this->render('admin/booking/new.html.twig', [
            'booking' => $booking,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="booking_show", methods={"GET"})
     */
    public function show(Booking $booking): Response
    {
        return $this->render('admin/booking/show.html.twig', [
            'booking' => $booking,
        ]);
    }

    /**
     * @Route("/{id}/editer", name="booking_edit", methods={"GET","POST"})
     * @param Request $request
     * @param MailerInterface $mailer
     * @return Response
     */
    public function edit(Request $request, Booking $booking, MailerInterface $mailer): Response
    {
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $email = (new Email())
                ->from($this->getParameter('mailer_from'))
                ->to($this->getParameter('mailer_from'))
                ->subject('Un cours a été déplacé')
                ->html($this->renderView('emails/_notification.html.twig', [ 'booking' => $booking]));
            $mailer->send($email);
            $this->addFlash('success', 'L\'événement a bien été mis à jour');

            return $this->redirectToRoute('booking_index');
        }

        return $this->render('admin/booking/edit.html.twig', [
            'booking' => $booking,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="booking_delete", methods={"DELETE"})
     * @param Request $request
     * @param MailerInterface $mailer
     * @return Response
     */
    public function delete(Request $request, Booking $booking, MailerInterface $mailer): Response
    {
        if ($this->isCsrfTokenValid('delete'.$booking->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($booking);
            $entityManager->flush();

            $this->addFlash('error', 'L\'évenement a bien été supprimé');

            $email = (new Email())
            ->from($this->getParameter('mailer_from'))
            ->to($this->getParameter('mailer_from'))
            ->subject('Un cours a été annulé')
            ->html($this->renderView('emails/_cancel.html.twig', [ 'booking' => $booking]));
            $mailer->send($email);
  
        }

        return $this->redirectToRoute('booking_index');
    }
}