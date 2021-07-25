<?php

namespace App\Controller\Admin;

use App\Entity\ProductPhoto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductPhotoController extends AbstractController
{
    /**
     * @Route("/product/photo/{productPhoto}", name="admin_product_photo_remove")
     */
    public function remove(ProductPhoto $productPhoto, EntityManagerInterface $em): RedirectResponse
    {
        $product = $productPhoto->getProduct()->getId();

        $realImage = $this->getParameter('upload_dir') . '/upload/' . $productPhoto->getPhoto();
        // Remover imagem da BD
        $em->remove($productPhoto);
        $em->flush();;

        // Remover a imagem do diretorio
        if(file_exists($realImage)){
            unlink($realImage);
        }

        return $this->redirectToRoute('admin_edit_products', ['product' => $product]);
    }
}
