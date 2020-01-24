<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Booking;
use App\Form\BookingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;

class BookingController extends AbstractController
{
    /**
     * @Route("/ads/{slug}/book", name="booking_create")
     * @IsGranted("ROLE_USER")
     */
    public function book(Ad $ad, Request $request, EntityManagerInterface $manager)
    {
       $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);

        $form->handleRequest($request);


        if($form->isSubmitted() && $form-> isValid()) {
             $user = $this->getUser();

             $booking->setBooker($user)
                     ->setAd($ad);

             // Si les dates choisies ne sont pas disponibles, message d'erreur
             if(!$booking->isBookableDates()){
                 $this->addFlash(
                     'warning',
                     "Les dates que vous avez choisies ne peuvent être réservées : Elles sont déjà prises."
                 );
                // Sinon enregistrement et redirection    
             } else {
                     $manager->persist($booking);
                     $manager->flush(); 
                     return $this->redirectToRoute('booking_show', ['id' => $booking->getId(),
                    'withAlert' => true]);
                   }
           }

        return $this->render('booking/book.html.twig', [
            'ad' => $ad,
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet l'afficher la page d'une réservation
     * @Route("/booking/{id}", name="booking_show")
     * @param Booking $booking
     * @return Response
     */
    public function show(Booking $booking) {
        return $this->render('booking/show.html.twig', [
               'booking' => $booking
        ]);
    }
    

} 
