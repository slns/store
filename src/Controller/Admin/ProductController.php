<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/product", name="admin_")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="index_products")
     */
    public function index(): Response
    {
        // Buscar todos os produtos
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        var_dump($products);

        return $this->render('admin/product/index.html.twig', compact('products'));
    }

    /**
     * @Route("/create", name="create_products")
     */
    public function create(): Response
    {
    }

    /**
     * @Route("/store", name="store_products", methods={"POST"})
     */
    public function store(): Response
    {
        // Registrar
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
    }

    /**
     * @Route("/edit/{product}", name="edit_products")
     *
     * @param mixed $product
     */
    public function edit($product): Response
    {
        // Buscar um produto especifico
        $products = $this->getDoctrine()->getRepository(Product::class)->find($product);
    }

    /**
     * @Route("/update/{product}", name="update_products", methods={"POST"})
     *
     * @param mixed $product
     */
    public function update($product): Response
    {
        // Atualizar
        $product = $this->getDoctrine()->getRepository(Product::class)->find($product);

        $product->setName('Produto Teste Editado');
        $product->setUpdatedAt(new DateTimeImmutable('now', new DateTimeZone('Europe/Lisbon')));

        $manager = $this->getDoctrine()->getManager();
        $manager->flush();
    }

    /**
     * @Route("/remove/{product}", name="remove_products", methods={"POST"})
     *
     * @param mixed $product
     */
    public function remove($product): Response
    {
        // Remover
        $product = $this->getDoctrine()->getRepository(Product::class)->find($product);

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($product);
        $manager->flush();
    }
}
