<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ImageType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name')
                ->setLabel('Nom du produit'),
            TextEditorField::new('description')
                ->setLabel('Description du produit'),
            BooleanField::new('rent')
                ->setLabel('Disponible à la location'),
            CollectionField::new('images')
                ->setLabel('Images du produit')
                ->setEntryType(ImageType::class)
                ->setFormTypeOptions([
                    'by_reference' => false,
                    'allow_add' => true,
                    'allow_delete' => true,
                ])
                ->setEntryIsComplex(true)
                ->onlyOnForms(),
            CollectionField::new('images')
                ->setLabel('Images du produit')
                ->setTemplatePath('admin/fields/images.html.twig')
                ->onlyOnIndex(),
        ];
    }
}