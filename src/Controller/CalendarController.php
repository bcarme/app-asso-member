<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/planning")
 */

class CalendarController extends AbstractController
{

    /**
     * @Route("/", name="app_calendar", methods={"GET"})
     */
    public function calendar(): Response
    {
        return $this->render('calendar/calendar.html.twig');
    }

}
