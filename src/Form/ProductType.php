<?php

// namespace App\Form;

// use App\Entity\Product;
// use App\Entity\Image;
// use Symfony\Component\Form\AbstractType;
// use Symfony\Component\Form\Extension\Core\Type\CollectionType;
// use App\Form\Type\ImageType;
// use Symfony\Component\Form\Extension\Core\Type\FileType;
// use Symfony\Component\Form\Extension\Core\Type\FormType;
// use Symfony\Component\Form\FormBuilderInterface;
// use Symfony\Component\Form\FormEvent;
// use Symfony\Component\Form\FormEvents;
// use Symfony\Component\OptionsResolver\OptionsResolver;

// class ProductType extends AbstractType
// {
//     public function buildForm(FormBuilderInterface $builder, array $options): void
//     {
//         $builder
//             ->add('name')
//             ->add('description')
//             ->add('rent')
//             ->add('images', CollectionType::class, [
//                 'entry_type' =>ImageType::class,
//                 // 'entry_options' => [
//                 //     'data_class' => Image::class,
//                 //     'label' => false,
//                 //     'mapped' => false, // pour éviter la liaison automique
//                 //     'required' => true,
//                 // ],
//                 'allow_add' => true,
//                 'allow_delete' => true,
//                 'by_reference' => false,
//             ])
//         ;

//         // Ajoutez cet événement pour convertir les fichiers téléchargés en entités Image
//         $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
//             $product = $event->getData();
//             $form = $event->getForm();

//             // Supprimez les anciennes images
//             $product->getImages()->clear();

//             foreach ($form->get('images')->getData() as $imageFile) {
//                 $image = new Image();
//                 $image->setImageFile($imageFile);
//                 $image->setProduct($product);
//                 $product->addImage($image);
//             }
//         });
//     }

//     public function configureOptions(OptionsResolver $resolver): void
//     {
//         $resolver->setDefaults([
//             'data_class' => Product::class,
//         ]);
//     }
// }

namespace App\Form;

use App\Entity\Product;
use App\Entity\Image;
use App\Form\ImageType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du produit',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description du produit',
                'required' => false,
            ])
            ->add('rent', CheckboxType::class, [
                'label' => 'Disponible à la location',
                'required' => false,
            ])
            ->add('images', CollectionType::class, [
                'entry_type' => ImageType::class, // Sous-formulaire pour les entités Image
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false, // Nécessaire pour ajouter correctement les nouvelles entités à la collection
            ]);

        // Événement pour gérer les fichiers téléchargés et les transformer en entités Image
        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $product = $event->getData();
            $form = $event->getForm();

            $images = new ArrayCollection();

            // Parcourt les sous-formulaires liés aux images
            foreach ($form->get('images') as $imageForm) {
                /** @var Image $image */
                $image = $imageForm->getData();

                if ($image && $image->getImageFile()) {
                    $image->setProduct($product);
                    $images->add($image);
                }
            }

            // Efface les anciennes images et ajoute les nouvelles
            $product->getImages()->clear();
            foreach ($images as $image) {
                $product->addImage($image);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
