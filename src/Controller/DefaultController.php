<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index(): Response
    {
        $name = 'Sérgio Santos !';

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
