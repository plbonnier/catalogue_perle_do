<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des Produits') // Titre de la page d'index
            ->setPageTitle(Crud::PAGE_NEW, 'Créer un produit') // Titre de la page de création
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier le produit') // Titre de la page d'édition
            ->setPageTitle(Crud::PAGE_DETAIL, 'Détails du produit'); // Titre de la page de détails
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, 'detail')
            ->update(Crud::PAGE_INDEX, 'new', function (Action $action) {
                return $action->setLabel('Ajouter un produit');
            });
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
            ImageField::new('picture')
                ->setLabel('Image du produit')
                ->setBasePath('uploads/images/pictures/')
                ->setUploadDir('public/uploads/images/pictures'),
        ];
    }
}
