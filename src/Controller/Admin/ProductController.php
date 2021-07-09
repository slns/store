<?php

namespace App\Controller\Admin;


use App\Entity\Product;
use App\Form\ProductType;
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
        dump('test');
        // Buscar todos os produtos
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        ///var_dump($products);

        return $this->render('admin/product/index.html.twig', compact('products'));
    }

    /**
     * @Route("/create", name="create_products")
     * @throws \Exception
     */
    public function create(Request $request): ?Response
    {
        $form = $this->createForm(ProductType::class, new Product());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $product->setCreatedAt();
            $product->setUpdatedAt();
            // dd( $product);
            $this->getDoctrine()->getManager()->persist($product);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Produto criado com sucesso.');

            return $this->redirectToRoute('admin_index_products');
        }

        return $this->render('admin/product/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{product}", name="edit_products")
     *
     * @param mixed $product
     */
    public function edit($product, Request $request): ?Response
    {
        // Buscar um produto especifico
        $product = $this->getDoctrine()->getRepository(Product::class)->find($product);

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted()  && $form->isValid()) {
            $product = $form->getData();
            $product->setUpdatedAt();
            // dd( $product);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Produto atualizado com sucesso.');

            return $this->redirectToRoute('admin_edit_products', ['product' => $product->getId()]);

        }

        return $this->render('admin/product/edit.html.twig', [
            'form' => $form->createView()
        ]);
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
