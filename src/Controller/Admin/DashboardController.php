<?php

namespace App\Controller\Admin;

use App\Entity\Answer;
use App\Entity\CerbereHabilitation;
use App\Entity\Document;
use App\Entity\Log;
use App\Entity\Notification;
use App\Entity\Question;
use App\Entity\RequestedAccess;
use App\Entity\Role;
use App\Entity\Service;
use App\Entity\Submission;
use App\Entity\User;
use App\Entity\ValidationStep;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // 1.1) If you have enabled the "pretty URLs" feature:
        // return $this->redirectToRoute('admin_user_index');
        //
        // 1.2) Same example but using the "ugly URLs" that were used in previous EasyAdmin versions:
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirectToRoute('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('DIRM');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Utilisateurs');
        yield MenuItem::linkToCrud('Users', 'fa fa-user', User::class);
        yield MenuItem::linkToCrud('Roles', 'fa fa-user-shield', Role::class);

        yield MenuItem::section('Formulaires');
        yield MenuItem::linkToCrud('Questions', 'fa fa-question', Question::class);
        yield MenuItem::linkToCrud('Réponses', 'fa fa-reply', Answer::class);
        yield MenuItem::linkToCrud('Soumissions', 'fa fa-paper-plane', Submission::class);

        yield MenuItem::section('Structures & Services');
        yield MenuItem::linkToCrud('Services', 'fa fa-building', Service::class);

        yield MenuItem::section('Suivi');
        yield MenuItem::linkToCrud('Étapes de validation', 'fa fa-check-circle', ValidationStep::class);
        yield MenuItem::linkToCrud('Habilitations', 'fa fa-key', CerbereHabilitation::class);
        yield MenuItem::linkToCrud('Demandes d\'accès', 'fa fa-lock', RequestedAccess::class);

        yield MenuItem::section('Support');
        yield MenuItem::linkToCrud('Notifications', 'fa fa-bell', Notification::class);
        yield MenuItem::linkToCrud('Documents', 'fa fa-file', Document::class);
        yield MenuItem::linkToCrud('Logs', 'fa fa-history', Log::class);
    }
}
