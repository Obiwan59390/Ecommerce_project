<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Laminas\Code\Generator\DocBlock\Tag\ReturnTag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\Checkout\Session;
use Stripe\Product;
use Stripe\Stripe;
use Symfony\Component\HttpFoundation\JsonResponse;


class StripeController extends AbstractController
{

    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em=$em;
    }

    #[Route('commande/create-session/{reference}', name: 'stripe_create_session')]
    public function index($reference): Response
    {
        //   clé secréte
        Stripe::setApiKey('sk_test_51KT0x4KYkuW3mSyptDe161yLshcUjpbH2bsWyuBwA4Bvgmpb9oM8YpxDpAdf9XrzEpyYiyCSR6XeeA8RDHWvi8kJ003cTFCMLT');
        $YOUR_DOMAIN = 'http://127.0.0.1:8000';
        $commande = $this->em->getRepository(Commande::class)->findOneBy(['reference'=>$reference]); 
        foreach($commande->getCommandeLignes()->getValues() as $product){
            $prod = $this->em->getRepository(Product::class)->findOneBy(['name'=>$product->getProductName()]);
            $sessionProducts[]=[
                'price_data' => [
                    'currency'=>'eur',
                    'unit_amount' => $product->getProductPrice() *100,
                    'product_data' => [
                        'name' => $product->getProductName(),
                        'images' => ["assets/images/products/".$prod->getImage()],
                    ]
                    ],
                    'quantity' =>$product->getProductQuantity(),
                    ];

        }
        
        $sessionProducts[] = [
                'currency'=>'eur',
                'unit_amount' => $commande->getTprix() *100,
                'product_data'=>[
                    'name' => $commande->getTsociete(),
                    'images' => [$YOUR_DOMAIN]
                ],
            'quantity' => 1
            ];
        $checkout_session = Session::create([

        'customer_email' => $this->getUser()->getEmail(),
        'paymenet_method_types' =>['card'],
        
        'line_items' => [
            $sessionProducts
    ],
  
    'mode' => 'payment',
  
      'success_url' => $YOUR_DOMAIN . '/commande/success/{CHECKOUT_SESSION_ID}',
  
      'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
  
  ]);
      $sessionId=$checkout_session->id;
      $commande->setStripeID($sessionId);
      $this->em->flush();
      $reponse= new JsonResponse(['id'=>$sessionId]);
      return $reponse;
    }
}
