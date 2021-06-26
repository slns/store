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

        $product = new Product();
        $product->setName('Produto Teste 2');
        $product->setDescription('Descrição 2');
        $product->setBody('Info Produto 2');
        $product->setSlug('produto-test-2');
        $product->setPrice(2990);
        $product->setCreatedAt(new DateTimeImmutable('now', new DateTimeZone('Europe/Lisbon')));
        $product->setUpdatedAt(new DateTimeImmutable('now', new DateTimeZone('Europe/Lisbon')));

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($product);
        $manager->flush();


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
