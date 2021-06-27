<?php

namespace App\Controller;

use DateTimeZone;
use \DateTimeImmutable;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index(): Response
    {
        $name = 'Sérgio Santos !';

        /*******  Buscar todos os produtos *******/
        // $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        // dump($products);

        /*******  Buscar um produto especifico *******/
        // $products = $this->getDoctrine()->getRepository(Product::class)->find(2);
        // print($products->getName());
        // dump($products);

        /*******  Buscar um produto por slug *******/
        // $products = $this->getDoctrine()->getRepository(Product::class)->findOneBy(['price' => 2990]);
        // $products = $this->getDoctrine()->getRepository(Product::class)->findOneByPrice(2990);
        // $products = $this->getDoctrine()->getRepository(Product::class)->findBy(['id' => 2]);
        // $products = $this->getDoctrine()->getRepository(Product::class)->findBySlug('produto-test-2');
        // dump($products);

        // return $this->render('index.html.twig', [
        //     'name' => $name
        // ]);

        return $this->render('index.html.twig', compact('name'));
    }


     /**
     * @Route("/product/{slug}", name="default_single")
     */
    public function product($slug): Response
    {
        return $this->render('single.html.twig', compact('slug'));
    }
}
