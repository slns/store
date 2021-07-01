<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        ///var_dump($products);

        return $this->render('admin/product/index.html.twig', compact('products'));
    }

    /**
     * @Route("/create", name="create_products")
     */
    public function create(): ?Response
    {
        return $this->render('admin/product/create.html.twig');
    }

    /**
     * @Route("/store", name="store_products", methods={"POST"})
     */
    public function store(Request $request): Response
    {
        try {
            $data = $request->request->all();

            $product = new Product();
            $product->setName($data['name']);
            $product->setDescription($data['description']);
            $product->setBody($data['body']);
            $product->setSlug($data['slug']);
            $product->setPrice($data['price']);

            $product->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Lisbon')));
            $product->setUpdatedAt(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Lisbon')));

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($product);
            $manager->flush();

            $this->addFlash('success', 'Produto criado com sucesso.');

            return $this->redirectToRoute('admin_index_products');
        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    /**
     * @Route("/edit/{product}", name="edit_products")
     *
     * @param mixed $product
     */
    public function edit($product): ?Response
    {
        // Buscar um produto especifico
        $product = $this->getDoctrine()->getRepository(Product::class)->find($product);

        return $this->render('admin/product/edit.html.twig', compact('product'));
    }

    /**
     * @Route("/update/{product}", name="update_products", methods={"POST"})
     *
     * @param mixed $product
     */
    public function update($product, Request $request): ?Response
    {
        // Atualizar
        try {
            $data = $request->request->all();

            $product = $this->getDoctrine()->getRepository(Product::class)->find($product);

            $product->setName($data['name']);
            $product->setDescription($data['description']);
            $product->setBody($data['body']);
            $product->setSlug($data['slug']);
            $product->setPrice($data['price']);

            $product->setUpdatedAt(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Lisbon')));

            $manager = $this->getDoctrine()->getManager();
            $manager->flush();

            $this->addFlash('success', 'Produto atualizado com sucesso.');

            return $this->redirectToRoute('admin_edit_products', ['product' => $product->getId()]);
        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    /**
     * @Route("/remove/{product}", name="remove_products")
     *
     * @param mixed $product
     */
    public function remove($product): ?Response
    {
        // Remover
        try {
            $product = $this->getDoctrine()->getRepository(Product::class)->find($product);

            $manager = $this->getDoctrine()->getManager();
            $manager->remove($product);
            $manager->flush();

            $this->addFlash('success', 'Produto apagado com sucesso.');

            return $this->redirectToRoute('admin_index_products');
        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }
}
