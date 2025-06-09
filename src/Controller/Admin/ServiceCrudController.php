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
    ChoiceField,
    AssociationField
};
use EasyCorp\Bundle\EasyAdminBundle\Filter\{
    TextFilter,
    ChoiceFilter
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
            ->add(TextFilter::new('location', 'Emplacement'))
            ->add(ChoiceFilter::new('category', 'Catégorie')->setChoices(
                array_combine(Service::CATEGORIES, Service::CATEGORIES)
            ));
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [];

        $fields[] = FormField::addTab('🔧 Informations générales');
        $fields[] = IdField::new('id')->hideOnForm();
        $fields[] = TextField::new('name', 'Nom complet');
        $fields[] = TextField::new('code', 'Code service')->setHelp('Ex : SG-RH, SSGM, PHB-MRS');
        $fields[] = TextField::new('location', '📍 Emplacement');

        if ($pageName === Crud::PAGE_INDEX) {
            $fields[] = TextField::new('category', 'Type de service')
                ->formatValue(function ($value) {
                    $colors = [
                        'Administratif' => 'badge-secondary',
                        'Technique'     => 'badge-primary',
                        'Opérationnel'  => 'badge-success',
                        'Transversal'   => 'badge-warning',
                    ];
                    $color = $colors[$value] ?? 'badge-info';
                    return sprintf('<span class="badge %s">%s</span>', $color, $value);
                })
                ->renderAsHtml();
        } else {
            $fields[] = ChoiceField::new('category', 'Type de service')
                ->setChoices(array_combine(Service::CATEGORIES, Service::CATEGORIES));
        }

        $fields[] = TextEditorField::new('description', '📝 Description')->hideOnIndex();

        $fields[] = FormField::addTab('👥 Utilisateurs assignés')->onlyOnDetail();
        $fields[] = AssociationField::new('users', '👥 Utilisateurs')->onlyOnDetail();

        return $fields;
    }
}
