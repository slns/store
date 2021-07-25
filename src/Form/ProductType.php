<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'label' => 'Nome Do Produto',
                'help' => 'Nome de ajuda'
            ])
            ->add('description', null, [
                'label' => 'Descrição Rápida'
            ])
            ->add('body', null, [
                'label' => 'Conteúdo'
            ])
//            ->add('price', TextType::class)
            ->add('price', TextType::class, [
                'label' => 'Preço'
            ])
            ->add('photos', FileType::class, [
                'mapped' => false,
                'multiple' => true,
            ])
            ->add('slug')
            ->add('category', null, [
                'label' => 'Categorias',
                // 'multiple' => false,
                'choice_label' => function($category) {
                    return sprintf('(%d) %s', $category->getId(), $category->getName());
                },
                // 'placeholder' => 'Selecione uma Categoria'

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
