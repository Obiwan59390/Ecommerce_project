<?php

namespace App\Controller;

use App\Classe\Panier;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\TextUI\Command;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StripeReturnController extends AbstractController
{
    #[Route('/commande/success/{StripId}', name: 'commande_success')]
    
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    public function index($stripId, Panier $panier): Response
    {
        $commande = $this->em
            ->getRepository(Commande::class)
            ->findOneBy(['stripeId' => $stripId]);
        if(!$commande){
            return $this->redirectToRoute('acceuil');
        }
        $commande->setIsFinalized(1);
        $this->el->flush();
        $panier->vider();

        return $this->render('stripeReturn/success.html.twig',[
            'commande'=>$commande,
        ]);
    }
}
