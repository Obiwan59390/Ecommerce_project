<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Product;
use App\Form\SearchType;
use App\Classe\Search;


class CatalogueController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/catalogue', name: 'catalogue')]
    public function index(Request $request): Response
    {
        
        $products = $this->em->getRepository(Product::class)->findAll();

        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $search = $form->getData();
            $products = $this->em->getRepository(Product::class)->findBySearch($search);
        }

        return $this->render('catalogue/produits.html.twig', [
            'products' => $products,
            'f' => $form->createView()
        ]);
    }

    #[Route('/product/{id}', name: 'product')]
    public function detailsProduct($id): Response
    {
        //dd($slug);
        $product = $this->em->getRepository(Product::class)->find($id);
        if(!$product){
            return $this->redirectToRoute('catalogue');
        }
        // dd($products);
        return $this->render('catalogue/detailsProduct.html.twig', [
            'product' => $product
        ]);
    }
}
