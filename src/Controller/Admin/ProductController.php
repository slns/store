<?php

namespace App\Controller\Admin;


use App\Entity\Product;
use App\Entity\ProductPhoto;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Service\UploadService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
        // dump($uploadService->upload());
        // Buscar todos os produtos
        $products = $productRepository->findAll();
        ///var_dump($products);

        return $this->render('admin/product/index.html.twig', compact('products'));
    }

    /**
     * @Route("/upload")
     * @throws Exception
     */
    public function upload(Request $request, UploadService $uploadService): Response
    {
        /** @var UploadedFile[] $photos */
        $photos = $request->files->get('photos');
        // $folder = $this->getParameter('upload_dir') . '/products';
        $uploadService->upload($photos, 'products');

        return new Response('Upload');
    }

    /**
     * @Route("/create", name="create_products")
     * @throws Exception
     */
    public function create(Request $request, EntityManagerInterface $em, UploadService $uploadService): ?Response
    {
        $form = $this->createForm(ProductType::class, new Product());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Product $product */
            $product = $form->getData();
            $product->setCreatedAt();
            $product->setUpdatedAt();
            //  dd( $product);

            $photosUpload = $form['photos']->getData();
            if ($photosUpload) {
                $photosUpload = $uploadService->upload($photosUpload, 'products');
                // dd($photosUpload);
                $photosUpload = $this->makeProductPhotoEntities($photosUpload);
                $product->addManyProductPhoto($photosUpload);
            }
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
     * @throws Exception
     */
    public function edit(
        $product, Request $request,
        ProductRepository $productRepository,
        EntityManagerInterface $em,
        UploadService $uploadService
    ): ?Response
    {
        // Buscar um produto especifico
        $product = $productRepository->find($product);

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $product->setUpdatedAt();
            //  dd( $product);

            $photosUpload = $form['photos']->getData();
            if ($photosUpload) {
                $photosUpload = $uploadService->upload($photosUpload, 'products');
                // dd($photosUpload);
                $photosUpload = $this->makeProductPhotoEntities($photosUpload);
                $product->addManyProductPhoto($photosUpload);
            }

            $em->flush();

            $this->addFlash('success', 'Produto atualizado com sucesso.');

            return $this->redirectToRoute('admin_edit_products', ['product' => $product->getId()]);

        }

        return $this->render('admin/product/edit.html.twig', [
            'form' => $form->createView(),
            'productPhotos' => $product->getProductPhotos()
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

    private function makeProductPhotoEntities($photosUpload)
    {
        $entities = [];
        foreach ($photosUpload as $photo) {
            $productPhoto = new ProductPhoto();
            $productPhoto->setPhoto($photo);
            $productPhoto->setCreatedAt();
            $productPhoto->setUpdatedAt();
            $entities[] = $productPhoto;
        }
        return $entities;
    }
}
