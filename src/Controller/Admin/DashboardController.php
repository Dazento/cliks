<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Entity\Product;
use App\Entity\ProductCategory;
use App\Entity\ProductImage;
use App\Entity\ProductStatus;
use App\Entity\User;
use App\Entity\UserAdress;
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
        return $this->redirect($adminUrlGenerator->setController(OrderCrudController::class));

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
            MenuItem::linkToCrud('Cr??er un produit', 'fas fa-plus', Product::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les produits', 'fas fa-eye', Product::class),
        ]);

        yield MenuItem::subMenu('Cat??gories', 'fas fa-list')->setSubItems([
            MenuItem::linkToCrud('Cr??er une Cat??gorie', 'fas fa-plus', ProductCategory::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les Cat??gories', 'fas fa-eye', ProductCategory::class),
        ]);

        yield MenuItem::subMenu('Images', 'fas fa-images')->setSubItems([
            MenuItem::linkToCrud('Ajouter une image', 'fas fa-plus', ProductImage::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les images', 'fas fa-eye', ProductImage::class),
        ]);

        yield MenuItem::subMenu('Status', 'fas fa-list')->setSubItems([
            MenuItem::linkToCrud('Cr??er un status', 'fas fa-plus', ProductStatus::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les status', 'fas fa-eye', ProductStatus::class),
        ]);

        yield MenuItem::section('Utilisateurs');

        yield MenuItem::subMenu('Utilisateurs', 'fa fa-user')->setSubItems([
            MenuItem::linkToCrud('Cr??er un user', 'fas fa-plus', User::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les users', 'fas fa-eye', User::class),
        ]);

        yield MenuItem::subMenu('AdresseUtilisateurs', 'fa fa-location-dot')->setSubItems([
            MenuItem::linkToCrud('Cr??er une adresse', 'fas fa-plus', UserAdress::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les adresses', 'fas fa-eye', UserAdress::class),
        ]);

        yield MenuItem::section('Commandes');

        yield MenuItem::subMenu('Commandes', 'fa fa-truck')->setSubItems([
            MenuItem::linkToCrud('Cr??er une commande', 'fas fa-plus', Order::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les commandes', 'fas fa-eye', Order::class),
        ]);

        yield MenuItem::subMenu('D??tails', 'fa fa-list')->setSubItems([
            MenuItem::linkToCrud('Cr??er une details', 'fas fa-plus', OrderDetail::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les details', 'fas fa-eye', OrderDetail::class),
        ]);
    }
}
