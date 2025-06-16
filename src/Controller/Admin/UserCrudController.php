<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
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
use Symfony\Component\HttpFoundation\RequestStack;

class UserCrudController extends AbstractCrudController
{
    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly ServiceRepository $serviceRepository
    ) {}

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
            ->setPageTitle(Crud::PAGE_DETAIL, '🧾 Détails du profil')
            ->setFormOptions([
                'attr' => ['data-controller' => 'service-types']
            ]);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('role'))
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
                'Autre' => 'Autre',
            ]));
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [];

        $fields[] = FormField::addTab('👤 Informations personnelles');
        $fields[] = NumberField::new('id', 'ID')->hideOnForm();

        if ($pageName === Crud::PAGE_INDEX) {
            $fields[] = TextField::new('fullName', '👥 Nom complet')->onlyOnIndex();
        }

        $fields[] = TextField::new('firstName', '🧑‍💼 Prénom')->setColumns(6)->hideOnIndex();
        $fields[] = TextField::new('lastName', '👤 Nom')->setColumns(6)->hideOnIndex();
        $fields[] = EmailField::new('email', '📧 Email')->setColumns(6)->hideOnIndex();
        $fields[] = TelephoneField::new('phoneNumber', '📞 Téléphone')->setColumns(6);
        $fields[] = TextField::new('address', '🏠 Adresse')->setColumns(6)->hideOnIndex();
        $fields[] = TextField::new('city', '🏙 Ville')->setColumns(4)->hideOnIndex();
        $fields[] = TextField::new('zipCode', '📮 Code postal')->setColumns(4)->hideOnIndex();
        $fields[] = CountryField::new('country', '🌍 Pays')->setColumns(4)->hideOnIndex();

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
        $fields[] = TextField::new('password', '🔒 Mot de passe')->hideOnIndex()->hideOnDetail()->setColumns(6);
        $fields[] = BooleanField::new('isVerified', '✅ Vérifié')->renderAsSwitch(false);
        $fields[] = BooleanField::new('isActive', '🟢 Actif')->renderAsSwitch(false);
        $fields[] = DateTimeField::new('createdAt', '🕒 Créé le')->onlyOnDetail();

        $fields[] = FormField::addTab('🏢 Affectation');
        $fields[] = AssociationField::new('role', '🔐 Rôle')->setColumns(6);

        $fields[] = AssociationField::new('service', '🏢 Service')
            ->setColumns(6)
            ->setFormTypeOption('attr', [
                'data-controller' => 'service-types',
                'data-action' => 'change->service-types#loadOptions',
                'data-service-types-target' => 'serviceSelect',
                'data-ea-widget' => 'select',
            ]);

        $fields[] = ChoiceField::new('serviceType', '🏷 Type de service')
            ->renderAsNativeWidget()
            ->setRequired(false)
            ->setFormTypeOption('attr', [
                'data-service-types-target' => 'typeField',
                'data-ea-widget' => 'select',
            ])
            ->setColumns(6);

        $fields[] = ChoiceField::new('serviceLocation', '📍 Emplacement')
            ->renderAsNativeWidget()
            ->setRequired(false)
            ->setFormTypeOption('attr', [
                'data-service-types-target' => 'locationField',
                'data-ea-widget' => 'select',
            ])
            ->setColumns(6);

        return $fields;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof User) {
            $this->hydrateService($entityInstance);
        }

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof User) {
            $this->hydrateService($entityInstance);
        }

        parent::updateEntity($entityManager, $entityInstance);
    }

    private function hydrateService(User $user): void
    {
        $request = $this->requestStack->getCurrentRequest();
        $formData = $request->request->all()['User'] ?? null;

        if (isset($formData['service']) && is_numeric($formData['service'])) {
            $service = $this->serviceRepository->find($formData['service']);
            $user->setService($service);
            // Optionnel : récupérer type et location depuis l'API ou entité si nécessaire
        }
    }
}
