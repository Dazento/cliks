<?php

namespace App\Controller\Admin;

use App\Entity\ProductImage;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductImage::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            ImageField::new('image')
                ->setUploadDir("public/uploads/product")
                ->setBasePath("/uploads")
                ->setRequired(false)
                ->setUploadedFileNamePattern("[contenthash].[extension]")
            ,
            AssociationField::new('product')
                ->setFormTypeOption('choice_label','name'),
        ];
    }

}
