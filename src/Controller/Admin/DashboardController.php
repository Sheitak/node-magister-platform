<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Cryptocurrency;
use App\Entity\Masternode;
use App\Entity\User;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Node Magister Platform');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('community');
        yield MenuItem::linkToCrud('Users', 'fas fa-users', User::class);

        yield MenuItem::section('platform');
        yield MenuItem::linkToCrud('Cryptocurrencies', 'fab fa-bitcoin', Cryptocurrency::class)
        ->setQueryParameter('sortDirection', 'ASC');
        /*
        yield MenuItem::linkToCrud('Cryptocurrencies Details', 'fa fa-tags', Cryptocurrency::class)
        ->setAction('detail');
        ->setEntityId(1);
        */

        yield MenuItem::linkToCrud('Masternode', 'fas fa-network-wired', Masternode::class);

        yield MenuItem::section('links');
        yield MenuItem::linkToUrl('CoinGecko', 'fas fa-dragon', 'https://coingecko.com');
        yield MenuItem::linkToUrl('Explorer', 'fab fa-linode', '');

        yield MenuItem::section('config');
        // yield MenuItem::linkToLogout('Logout', 'fas fa-sign-out-alt');
        yield MenuItem::linkToExitImpersonation('Stop impersonation', 'fas fa-user-secret');
    }
}