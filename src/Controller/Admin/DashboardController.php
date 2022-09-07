<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Entity\ProductCategory;
use App\Entity\ProductImage;
use App\Entity\ProductStatus;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(): Response
    {

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(ProductCrudController::class));

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Cliks');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Produits');

        yield MenuItem::subMenu('Produits', 'fas fa-list')->setSubItems([
            MenuItem::linkToCrud('Créer un produit', 'fas fa-plus', Product::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les produits', 'fas fa-eye', Product::class),
        ]);

        yield MenuItem::subMenu('Catégories', 'fas fa-list')->setSubItems([
            MenuItem::linkToCrud('Créer une Catégorie', 'fas fa-plus', ProductCategory::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les Catégories', 'fas fa-eye', ProductCategory::class),
        ]);

        yield MenuItem::subMenu('Images', 'fas fa-list')->setSubItems([
            MenuItem::linkToCrud('Ajouter une image', 'fas fa-plus', ProductImage::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les images', 'fas fa-eye', ProductImage::class),
        ]);

        yield MenuItem::subMenu('Status', 'fas fa-list')->setSubItems([
            MenuItem::linkToCrud('Créer un status', 'fas fa-plus', ProductStatus::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les status', 'fas fa-eye', ProductStatus::class),
        ]);

        yield MenuItem::section('Utilisateurs');

        yield MenuItem::linkToCrud('User', 'fa fa-user', User::class);
    }
}
