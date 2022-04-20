<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ChoisirAdresseType;
use App\Form\ChoisirTransporteurType;
use Symfony\Component\HttpFoundation\Request;

class CouloirCommandeController extends AbstractController
{
    #[Route('/profil/choisir/adresse', name: 'choisirAdresse')]
    public function index(): Response
    {
        $form = $this->createForm(ChoisirAdresseType::class, null, [
            'user' => $this->getUser()
        ]);
        return $this->render('couloirCommande/choisirAdresse.html.twig', [
            'f' => $form->createView()
        ]);
    }

    #[Route('/profil/choisir/transporteur', name: 'choisirTransporteur')]
    public function choisirTransporteur(Request $request): Response
    {
        $adrL = null;
        $adrF = null;
        $formAdresse = $this->createForm(ChoisirAdresseType::class, null, [
            'user' => $this->getUser()
        ]);
        $formAdresse->handleRequest($request);
        if($formAdresse->isSubmitted() && $formAdresse->isValid()){
            $adrL = $formAdresse->get('adressesLivraison')->getData();
            $adrF = $formAdresse->get('adressesFacturation')->getData();
        }

        $form = $this->createForm(ChoisirTransporteurType::class, null, [
            'user' => $this->getUser()
        ]);
        return $this->render('couloirCommande/choisirTransporteur.html.twig', [
            'f' => $form->createView(),
            'adrL' => $adrL,
            'adrF' => $adrF
        ]);
    }
}
