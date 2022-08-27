<?php

namespace App\Controller\Admin;

use App\Entity\ProductStatus;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductStatusCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductStatus::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
