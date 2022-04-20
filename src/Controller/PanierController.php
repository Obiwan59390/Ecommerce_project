<?php

namespace App\Controller;

use App\Classe\Panier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{


    #[Route('/panier', name: 'panier')]
    public function index(Panier $Panier)  
    {  
        return $this->render('panier/Panier.html.twig', [
            'Cart' => $Panier->afficherTout(),
        ]);

    }

    #[Route('/add_cart/{id}', name: 'add_cart')]
    public function add($id,Panier $Panier){
        $Panier->ajouter($id);
        $this->addFlash(
            'success',
            "Produit ajouter au panier !"
        );
        return $this->redirectToRoute('catalogue');
    }
}
 