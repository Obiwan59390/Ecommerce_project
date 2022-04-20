<?php

namespace App\Controller;

use App\Form\ModifierPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ModifierPasswordController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }
    #[Route('/profil/modifierPassword', name: 'modifierPassword')]
    public function index(Request $request, UserPasswordHasherInterface $uphi): Response
    {
        $notif = null;
        
        $user = $this->getUser();
        $form = $this->createForm(ModifierPasswordType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $ancienPassword = $form->get("ancienPassword")->getData();
            if($uphi->isPasswordValid($user, $ancienPassword)){
                // Modification du mot de passe dans la BDD
                // récupérer le nouveau mot de passe 
                $nouveauPassword = $form->get("nouveauPassword")->getData();
                // crypter le nouveau mot de passe
                $pwd = $uphi->hashPassword($user, $nouveauPassword);
                // placer le mot de passe crypté dans l'objet $user 
                $user->setPassword($pwd);
                // Actualiser dans la BDD
                //$this->em->persist($user);
                $this->em->flush();
                $notif = "Félicitation mot de passe modifier correctement";
            }else{
                $notif = "Le mot de passe actuel n'est pas correct";
            }
        }

        return $this->render('profil/modifierPassword.html.twig', [
            'f' => $form->createView(),
            'notif' => $notif
        ]);
    }
}
