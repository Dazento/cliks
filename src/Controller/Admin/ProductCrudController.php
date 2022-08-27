<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            NumberField::new('price'),
            TextEditorField::new('description'),
            NumberField::new('reference'),
            NumberField::new('stock'),
            AssociationField::new('category')
            ->setFormTypeOption('choice_label','name'),
            AssociationField::new('status')
                ->setFormTypeOption('choice_label','name'),
            DateTimeField::new("modifiedAt")->setFormat("dd/MM/Y HH:mm"),
            DateTimeField::new("createdAt")->setFormat("dd/MM/Y HH:mm"),
        ];
    }

}
