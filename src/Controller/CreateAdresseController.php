<?php

namespace App\Controller;
use App\Entity\Adresse;
use App\Form\AdresseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateAdresseController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
    $this->em = $em;
    }
    #[Route('profil/create_adresse', name: 'create_adresse')]
    public function index(Request $request): Response
    {
        $adresse = new Adresse();
        $form = $this->createForm(AdresseType::class, $adresse);
    
        // écoute de la requête du submit 
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            // récupérer les données du formulaire
            $adresse = $form->getData();
            // figer les données à envoyer vers la BDD
            $this->em->persist($adresse);
            // Sauvegarde dans la BDD 
            $this->em->flush();
        }
    
            return $this->render('create_adresse/create_adresse.html.twig', [
                'createAdresse' => $form->createView(),
            ]);
        }}
