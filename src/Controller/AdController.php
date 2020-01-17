<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Entity\Image;
use App\Repository\AdRepository;
// use PhpParser\Node\Expr\FuncCall;
use Doctrine\ORM\EntityManagerInterface;
// use Doctrine\Common\Persistence\ObjectManager;
// use Symfony\Component\Form\Extension\Core\Type\SubmitType;
// use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    /**
     * @Route("/ads", name="ads_index")
     */
    public function index(AdRepository $repo)
    {
      
        $ads = $repo->findAll();
        
        return $this->render('ad/index.html.twig', [
            'ads' => $ads
        ]);
    }

    /**
      * Permet de créer une annonce
      *
      * @Route("/ads/new", name="ads_create")
      * 
      */
     public function create(Request $request, EntityManagerInterface $manager){
         $ad = new Ad();

         $form = $this->createForm(AdType::class, $ad);

         $form->handleRequest($request);

        // dump($ad);

         if($form->isSubmitted() && $form->isValid()){
              //save des images
                foreach($ad->getImages() as $image) {
                    $image->setAd($ad);
                    $manager->persist($image);
                  }  
                  
                  $ad->setAuthor($this->getUser());

                    $manager->persist($ad);
                    $manager->flush();
                   $this->addFlash(
                     'success',
                  "L'annonce <strong>{$ad->getTitle()}</strong> a bien été renregistrée"
                  );

              //Afficher l'enregistement créé
             return $this->redirectToRoute('ads_show', [
                 'slug' => $ad->getSlug()
               ]);
         }
         
         return $this->render('ad/new.html.twig', [
              'form' => $form->createView()
         ]); 
     } 


      /**
       * Permet d'afficher le formulaire d'edition
       * 
       * @Route("/ads/{slug}/edit", name="ads_edit")
       * 
       * @return Response
       */
      public function edit(Ad $ad, Request $request, EntityManagerInterface $manager){

          $form = $this->createForm(AdType::class, $ad);
          $form->handleRequest($request);

                if($form->isSubmitted() && $form->isValid()){
                    //save des images
                    foreach($ad->getImages() as $image) {
                        $image->setAd($ad);
                        $manager->persist($image);
                    }     
                        $manager->persist($ad);
                        $manager->flush();
                    $this->addFlash(
                    'success',
                    "Les modifications de l'annonce <strong>{$ad->getTitle()}</strong> ont bien été renregistrées"
                );

          //Afficher l'enregistement créé
         return $this->redirectToRoute('ads_show', [
             'slug' => $ad->getSlug()
           ]);
     }


         return $this->render('ad/edit.html.twig', [
              'form' => $form->createView(),
              'ad' => $ad
         ]);
      }

    /**
     * Permet d'afficher une seule annaonce
     * 
     * @Route("/ads/{slug}", name="ads_show")
     * 
     * @return Response
     */

    public Function show(Ad $ad){
        // Je récupère l'annonce qui correspond au slug    
       // $ad = $repo->findOneBySlug($slug);

        return $this->render('ad/show.html.twig',[
             'ad' => $ad
        ]); 
    }

    



}
