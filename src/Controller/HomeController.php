<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerResolver;
 

 class HomeController extends AbstractController {

    //   /**
    //    * @Route("/hello/{prenom}/age/{age}", name="hello")
    //    * @Route("/hello", name="hello_base")
    //    * @Route("/hello/{prenom}", name="hello_prenom")
    //    * Montre la page qui dit bonjour
    //    * 
    //    * @return void
    //    */
    //   public function hello($prenom = "anonyme", $age = 0){
    //     return $this->render(
    //         'hello.html.twig' , [ 'prenom' => $prenom,
    //                              'age' => $age]);

    //   }


      
    /**
     *  @Route("/", name="homepage") 
     */

      public function home(){
          $prenoms = ["Nicolas" => 12, "Agnes" => 9, "Axel" => 5];
          return $this->render(
              'home.html.twig' , [ 'title' => "Test de TWIG",
                                   'Age' => 12,
                                   'tableau' => $prenoms]
          );
      }

 }


?>

