<?php

namespace App\Controller\Admin;

use App\Entity\UserAdress;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserAdressCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserAdress::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('adressline'),
            TextField::new('zipcode'),
            TextField::new('city'),
            TelephoneField::new('phone'),
            AssociationField::new('user')
                ->setFormTypeOption('choice_label', 'email')
        ];
    }
    
}
