<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Category;
use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class DashboardController extends AbstractDashboardController
{
    private $adminUrlGenerator;
    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $url = $this->adminUrlGenerator
                    ->setController(UserCrudController::class)
                    ->generateUrl();
        return $this->redirect($url);

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
            ->setTitle('E-shop');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('E-shop');
        yield MenuItem::subMenu('Utilisateurs', 'fas fa-user-tie', User::class)
            ->setSubItems([
                MenuItem::linkToCrud('Ajouter', 'fas fa-plus', User::class)
                    ->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Visualiser', 'fas fa-eye', User::class)
            ]);
        yield MenuItem::subMenu('Categories', 'fas fa-bars', Category::class)
        ->setSubItems([
            MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Category::class)
                ->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Visualiser', 'fas fa-eye', Category::class)
        ]);
        yield MenuItem::subMenu('Produits', 'fab fa-elementor', Product::class)
        ->setSubItems([
            MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Product::class)
                ->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Visualiser', 'fas fa-eye', Product::class)
        ]);
        // yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user-tie', User::class);
    }
}
