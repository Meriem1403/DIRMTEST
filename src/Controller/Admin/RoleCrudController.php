<?php

namespace App\Controller\Admin;

use App\Entity\Role;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\{
    IdField,
    TextField,
    ArrayField,
    FormField
};
use EasyCorp\Bundle\EasyAdminBundle\Filter\{
    TextFilter
};

class RoleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Role::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::DETAIL, fn(Action $action) =>
            $action->setIcon('fa fa-eye')->setLabel('Voir')
            )
            ->update(Crud::PAGE_INDEX, Action::EDIT, fn(Action $action) =>
            $action->setIcon('fa fa-pen')->setLabel('Modifier')
            )
            ->update(Crud::PAGE_INDEX, Action::DELETE, fn(Action $action) =>
            $action->setIcon('fa fa-trash text-danger')->setLabel('Supprimer')
            );
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Rôle')
            ->setEntityLabelInPlural('Rôles')
            ->setPageTitle(Crud::PAGE_INDEX, '🔐 Liste des rôles')
            ->setPageTitle(Crud::PAGE_NEW, '➕ Créer un rôle')
            ->setPageTitle(Crud::PAGE_EDIT, '✏️ Modifier le rôle')
            ->setPageTitle(Crud::PAGE_DETAIL, 'Rôle')
            ->setDefaultSort(['id' => 'ASC']);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(TextFilter::new('name', 'Nom technique'))
            ->add(TextFilter::new('label', 'Nom affiché'));
    }

    public function configureFields(string $pageName): array
    {
        return [
            FormField::addTab('🔐 Informations de base'),
            IdField::new('id')->hideOnForm(),

            TextField::new('name', '🔧 Nom technique')
                ->setHelp('Ex : ROLE_ADMIN')
                ->setColumns(6),

            TextField::new('label', '🏷 Nom affiché')
                ->onlyWhenCreating()
                ->setHelp('Ex : Administrateur')
                ->setColumns(6),

            TextField::new('label', '🏷 Nom affiché')
                ->formatValue(function ($value) {
                    $colors = [
                        'Administrateur' => 'badge-danger',
                        'Utilisateur'    => 'badge-success',
                        'Invité'         => 'badge-info',
                    ];
                    $color = $colors[$value] ?? 'badge-info';
                    return sprintf('<span class="badge %s">%s</span>', $color, $value);
                })
                ->renderAsHtml()
                ->onlyOnIndex(),

            FormField::addTab('🧬 Hiérarchie de rôle'),
            ArrayField::new('hierarchy', 'Rôles inclus')
                ->hideOnIndex()
                ->setHelp('Liste des rôles enfants, ex: ["ROLE_AGENT", "ROLE_CHEF"]'),
        ];
    }
}
