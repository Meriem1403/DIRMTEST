<?php

namespace App\Controller\Admin;

use App\Entity\Service;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\{
    IdField,
    TextField,
    TextEditorField,
    FormField,
    ArrayField,
    AssociationField,
    Field
};
use EasyCorp\Bundle\EasyAdminBundle\Filter\{
    TextFilter
};

class ServiceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Service::class;
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
            $action->setIcon('fa fa-trash')->setLabel('Supprimer')->addCssClass('text-danger')
            );
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Service')
            ->setEntityLabelInPlural('Services DIRM')
            ->setPageTitle(Crud::PAGE_INDEX, '🏛️ Liste des services')
            ->setPageTitle(Crud::PAGE_NEW, '➕ Ajouter un service')
            ->setPageTitle(Crud::PAGE_EDIT, '✏️ Modifier le service')
            ->setDefaultSort(['id' => 'ASC']);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(TextFilter::new('name', 'Nom'))
            ->add(TextFilter::new('code', 'Code'))
            ->add(TextFilter::new('types', 'Types'))
            ->add(TextFilter::new('locations', 'Emplacements'));
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('🔧 Informations générales'),
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Nom du service'),
            TextField::new('code', 'Code')->setHelp('Ex : PHB-MRS, SG-RH, DIRM-TECH'),
            ArrayField::new('types', 'Types de service')->onlyOnForms()
                ->setHelp('Ex : Technique, Administratif, Opérationnel...'),
            ArrayField::new('locations', '📍 Emplacements multiples')->onlyOnForms()
                ->setHelp('Ex : COB de Toulon, COB de Marseille, COB de Sète…'),
            TextEditorField::new('description', '📝 Description')->hideOnIndex(),

            Field::new('nextTab')
                ->onlyOnForms()
                ->setLabel('')
                ->setFormTypeOption('mapped', false)
                ->setHelp('<div class="text-right mt-4"><span class="text-muted">➡️ Cliquez sur l’onglet <strong>👥 Utilisateurs assignés</strong> ci-dessus pour continuer</span></div>'),

            FormField::addTab('👥 Utilisateurs assignés')->onlyOnDetail(),
            AssociationField::new('users', '👥 Utilisateurs')->onlyOnDetail(),
        ];
    }
}
