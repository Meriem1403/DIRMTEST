<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\{
    AssociationField,
    BooleanField,
    CountryField,
    DateTimeField,
    EmailField,
    FormField,
    NumberField,
    TelephoneField,
    TextField,
    ChoiceField
};
use EasyCorp\Bundle\EasyAdminBundle\Filter\{
    BooleanFilter,
    EntityFilter,
    ChoiceFilter
};

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::DETAIL, fn(Action $a) => $a->setIcon('fa fa-eye')->setLabel('Voir'))
            ->update(Crud::PAGE_INDEX, Action::EDIT, fn(Action $a) => $a->setIcon('fa fa-pen')->setLabel('Modifier'))
            ->update(Crud::PAGE_INDEX, Action::DELETE, fn(Action $a) => $a->setIcon('fa fa-trash text-danger')->setLabel('Supprimer'));
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Profil')
            ->setEntityLabelInPlural('Profils')
            ->setPageTitle(Crud::PAGE_INDEX, '👥 Liste des profils')
            ->setPageTitle(Crud::PAGE_NEW, '➕ Créer un profil')
            ->setPageTitle(Crud::PAGE_EDIT, '✏️ Modifier le profil')
            ->setDefaultSort(['id' => 'ASC']);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('role'))
            ->add(EntityFilter::new('service'))
            ->add(BooleanFilter::new('isActive'))
            ->add(BooleanFilter::new('isVerified'))
            ->add(ChoiceFilter::new('status')->setChoices([
                'Titulaire' => 'Titulaire',
                'Contractuel' => 'Contractuel',
                'Vacataire' => 'Vacataire',
            ]))
            ->add(ChoiceFilter::new('category')->setChoices([
                'A' => 'A',
                'B' => 'B',
                'C' => 'C',
            ]));
    }

    public function configureFields(string $pageName): array
    {
        $fields = [];

        $fields[] = FormField::addTab('👤 Informations personnelles');
        $fields[] = NumberField::new('id', 'ID')->hideOnForm();

        if ($pageName === Crud::PAGE_INDEX) {
            $fields[] = TextField::new('fullName', '👥 Nom complet')->onlyOnIndex();
        }

        $fields[] = TextField::new('firstName', '🧑‍💼 Prénom')->setColumns(6)->hideOnIndex();
        $fields[] = TextField::new('lastName', '👤 Nom')->setColumns(6)->hideOnIndex();
        $fields[] = EmailField::new('email', '📧 Email')->setColumns(6);
        $fields[] = TelephoneField::new('phoneNumber', '📞 Téléphone')->setColumns(6);
        $fields[] = TextField::new('address', '🏠 Adresse')->setColumns(6);
        $fields[] = TextField::new('city', '🏙 Ville')->setColumns(4);
        $fields[] = TextField::new('zipCode', '📮 Code postal')->setColumns(4);
        $fields[] = CountryField::new('country', '🌍 Pays')->setColumns(4);

        $fields[] = FormField::addTab('💼 Poste & Statut');
        $fields[] = TextField::new('jobTitle', '🪪 Poste occupé')->setColumns(6);
        $fields[] = ChoiceField::new('status', '📄 Statut')
            ->setChoices([
                'Titulaire' => 'Titulaire',
                'Contractuel' => 'Contractuel',
                'Vacataire' => 'Vacataire',
            ])
            ->renderAsBadges([
                'Titulaire' => 'success',
                'Contractuel' => 'warning',
                'Vacataire' => 'danger',
            ])
            ->setColumns(3);
        $fields[] = ChoiceField::new('category', '📘 Catégorie')
            ->setChoices(['A' => 'A', 'B' => 'B', 'C' => 'C'])
            ->renderAsBadges([
                'A' => 'info',
                'B' => 'primary',
                'C' => 'secondary',
            ])
            ->setColumns(3);

        $fields[] = FormField::addTab('🔐 Statut et sécurité');
        $fields[] = TextField::new('password', 'Mot de passe')->hideOnIndex()->hideOnDetail()->setColumns(6);
        $fields[] = BooleanField::new('isVerified', '✅ Vérifié')->renderAsSwitch(false);
        $fields[] = BooleanField::new('isActive', '🟢 Actif')->renderAsSwitch(false);
        $fields[] = DateTimeField::new('createdAt', '🕒 Créé le')->onlyOnDetail();

        $fields[] = FormField::addTab('🏢 Affectation');
        $fields[] = AssociationField::new('role', '🔐 Rôle')->setColumns(6);
        $fields[] = AssociationField::new('service', '🏢 Service')->setColumns(6);

        return $fields;
    }
}
