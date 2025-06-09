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
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    private AdminUrlGenerator $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    public function index(): Response
    {
        // Redirige vers la liste des utilisateurs au chargement du dashboard
        $url = $this->adminUrlGenerator
            ->setController(UserCrudController::class)
            ->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('DIRM - Espace Administration')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Utilisateurs');
        yield MenuItem::linkToCrud('Profils', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Rôles', 'fas fa-user-shield', Role::class);

        yield MenuItem::section('Formulaires');
        yield MenuItem::linkToCrud('Questions', 'fas fa-question', Question::class);
        yield MenuItem::linkToCrud('Réponses', 'fas fa-reply', Answer::class);
        yield MenuItem::linkToCrud('Soumissions', 'fas fa-paper-plane', Submission::class);

        yield MenuItem::section('Structures & Services');
        yield MenuItem::linkToCrud('Services', 'fas fa-building', Service::class);

        yield MenuItem::section('Suivi');
        yield MenuItem::linkToCrud('Étapes de validation', 'fas fa-check-circle', ValidationStep::class);
        yield MenuItem::linkToCrud('Habilitations', 'fas fa-key', CerbereHabilitation::class);
        yield MenuItem::linkToCrud('Demandes d\'accès', 'fas fa-lock', RequestedAccess::class);

        yield MenuItem::section('Support');
        yield MenuItem::linkToCrud('Notifications', 'fas fa-bell', Notification::class);
        yield MenuItem::linkToCrud('Documents', 'fas fa-file', Document::class);
        yield MenuItem::linkToCrud('Logs', 'fas fa-history', Log::class);
    }
}
