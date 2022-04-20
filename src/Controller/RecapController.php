<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ChoisirTransporteurType;
use Symfony\Component\HttpFoundation\Request;
use App\Classe\Panier;

class RecapController extends AbstractController
{
    #[Route('/profil/recap/{adrL}/{adrF}', name: 'recap')]
    public function index($adrL, $adrF, Request $request, Panier $panier): Response
    {
        $transport = null;
        $formTransport = $this->createForm(ChoisirTransporteurType::class, null, [
            'user' => $this->getUser()
        ]);
        $formTransport->handleRequest($request);
        if($formTransport->isSubmitted() && $formTransport->isValid()){
            $transport = $formTransport->get('transporteurs')->getData();
        }

        return $this->render('recap/recap.html.twig', [
            'transport' => $transport,
            'panier' => $panier->afficherTout(),
            'adrL' => $adrL,
            'adrF' => $adrF,
            'reference' => $reference
        ]);
    }
}
