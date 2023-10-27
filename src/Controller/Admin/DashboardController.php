<?php

namespace App\Controller\Admin;

use App\Entity\Node\Brief;
use App\Entity\Node\Category;
use App\Entity\Node\Page;
use App\Entity\Node\Post;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('@EasyAdmin/dashboard.html.twig');
    }

    public function configureCrud(): Crud
    {
        return Crud::new()
            ->renderContentMaximized()
            ->setDateFormat('dd/MM/yyyy')
            ->setDateTimeFormat('dd/MM/yyyy HH:mm:ss');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('App')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::linkToCrud('Users', 'fa fa-user', User::class);

        yield MenuItem::section('Blog');
        yield MenuItem::linkToCrud('Posts', 'fa fa-newspaper', Post::class);
        yield MenuItem::linkToCrud('Briefs', 'fa fa-newspaper', Brief::class);
        yield MenuItem::linkToCrud('Pages', 'fa fa-newspaper', Page::class);
        yield MenuItem::linkToCrud('Categories', 'fa fa-folder', Category::class);
    }
}
