<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Category;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     * @throws \Exception
     */
    public function index(): Response
    {
        $name = 'Sérgio Santos !';
        $user = $this->getDoctrine()->getRepository(User::class)->find(2);
//        $order = $this->getDoctrine()->getRepository(Order::class)->find(1);
//
//        $user->removeOrder($order);
//
//        $this->getDoctrine()->getManager()->flush();

        // Buscar todos os produtos
        // $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        // dump($products);

        // Buscar um produto especifico
        // $products = $this->getDoctrine()->getRepository(Product::class)->find(2);
        // print($products->getName());
        // dump($products);

        // Buscar um produto por slug
        // $products = $this->getDoctrine()->getRepository(Product::class)->findOneBy(['price' => 2990]);
        // $products = $this->getDoctrine()->getRepository(Product::class)->findOneByPrice(2990);
        // $products = $this->getDoctrine()->getRepository(Product::class)->findBy(['id' => 2]);
        // $products = $this->getDoctrine()->getRepository(Product::class)->findBySlug('produto-test-2');
        // dump($products);

        // return $this->render('index.html.twig', [
        //     'name' => $name
        // ]);

        // $manager = $this->getDoctrine()->getManager();


//         $address = new Address();
//         $address->setAddress('Rua Teste');
//         $address->setNumber(100);
//         $address->setNeighborhood('Bairro');
//         $address->setCity('Matosinhos');
//         $address->setState('Porto');
//         $address->setZipcode('4000-000');
//         $address->setUser($user);
//
//         $manager->persist($address);
//         $manager->flush();

         /*$user = new User();
         $user->setFirstName('Utilizador');
         $user->setLastName('Teste');
         $user->setEmail('test@email.pt');
         $user->setPassword('123456');
         $user->setCreateAt(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Lisbon')));
         $user->setUpdatedAt(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Lisbon')));
        // $user->setAddress($address);
         $manager->persist($user);
         $manager->flush();

       //  $user = $this->getDoctrine()->getRepository(user::class)->find(2);
        // dump($user->getOrder()->toArray());

        $order = new Order();
        $order->setReference('Codigo Compra test');
        $order->setItems('Items test');
        $order->setUser($user);
        $order->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Lisbon')));
        $order->setUpdatedAt(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Lisbon')));

        $this->getDoctrine()->getManager()->persist($order);
        $this->getDoctrine()->getManager()->flush();*/

        // Produto e Categoria
//        $product = $this->getDoctrine()->getRepository(Product::class)->find(1);
//        dump($product->getCategories()->toArray());
        /*
        $category = new Category();
        $category->setName('Games');
        $category->setSlug('games');
        $category->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Lisbon')));
        $category->setUpdatedAt(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Lisbon')));

        $product->setCategory($category);


         $this->getDoctrine()->getManager()->persist($category);
        $this->getDoctrine()->getManager()->flush();*/

        return $this->render('index.html.twig', compact('name', 'user'));
    }

    /**
     * @Route("/product/{slug}", name="default_single")
     *
     * @param mixed $slug
     */
    public function product($slug): Response
    {
        return $this->render('single.html.twig', compact('slug'));
    }
}
