<?php

namespace App\Classe;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;

class Panier
{
    private $rs;
    private $em;
    public function __construct(RequestStack $rs, EntityManagerInterface $em)
    {
        $this->rs = $rs;
        $this->em = $em;
    }
    public function ajouter($id)
    {
        // Créer une sauvegarde
        $panier = $this->rs->getSession()->get('panier', []);
        if(!empty($panier[$id]))
        {
            $panier[$id]++;
        }else{
            $panier[$id] = 1;
        }

        

        $this->rs->getSession()->set('panier', $panier);

        // $this->rs->set('panier', [
        //     [
        //         'id' => $id,
        //         'quantite' => 1
        //     ]
        // ]);
    }
    public function afficher()
    {
        return $this->rs->getSession()->get('panier');
    }

    public function afficherTout()
    {
        $contenuPanier = [];
        if($this->afficher()){
            foreach($this->afficher() as $id => $quantite){
                $obj = $this->em->getRepository(Product::class)->find($id);
                if(!$obj){
                    $this->supprimer($id);
                    continue;
                }
                $contenuPanier[] = [
                    'product' => $obj,
                    'quantite' => $quantite
                ];
            }
        }
        return $contenuPanier;
    }
    public function vider()
    {
        return $this->rs->getSession()->remove('panier');
    }
    public function reduire($id)
    {
        $panier = $this->rs->getSession()->get('panier', []);
        if($panier[$id] > 1){
            $panier[$id]--;
        }else{
            unset($panier[$id]);
        }
        $this->rs->getSession()->set('panier', $panier);
    }
    public function supprimer($id)
    {
        $panier = $this->rs->getSession()->get('panier', []);
        unset($panier[$id]);
        $this->rs->getSession()->set('panier', $panier);
    }
    public function nbArticles()
    {
        $nb = 0;
        if($this->afficher()){
            foreach($this->afficher() as $id => $qty){
                $nb += $qty;
            }
        } 
        return $nb;
    }
}