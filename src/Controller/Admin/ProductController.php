<?php

namespace App\Controller\Admin;


use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Service\UploadService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
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
    public function index(ProductRepository $productRepository, UploadService $uploadService): Response
    {
        dump($uploadService->upload());
//        dump('test');
        // Buscar todos os produtos
        $products = $productRepository->findAll();
        ///var_dump($products);

        return $this->render('admin/product/index.html.twig', compact('products'));
    }

    /**
     * @Route("/create", name="create_products")
     * @throws Exception
     */
    public function create(Request $request, EntityManagerInterface $em): ?Response
    {
        $form = $this->createForm(ProductType::class, new Product());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $product->setCreatedAt();
            $product->setUpdatedAt();
            // dd( $product);
            $em->persist($product);
            $em->flush();

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
    public function edit($product, Request $request, ProductRepository $productRepository, EntityManagerInterface $em): ?Response
    {
        // Buscar um produto especifico
        $product = $productRepository->find($product);

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $product->setUpdatedAt();
            // dd( $product);
            $em->flush();

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
    public function remove($product, ProductRepository $productRepository, EntityManagerInterface $em): ?Response
    {
        // Remover
        try {
            $product = $productRepository->find($product);

           // $manager = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();

            $this->addFlash('success', 'Produto apagado com sucesso.');

            return $this->redirectToRoute('admin_index_products');
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }
}
