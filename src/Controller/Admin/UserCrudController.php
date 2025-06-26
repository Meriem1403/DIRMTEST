<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setFormOptions([
            'attr' => ['data-controller' => 'service-types']
        ]);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),

            TextField::new('firstName'),
            TextField::new('lastName'),
            EmailField::new('email'),
            TelephoneField::new('phoneNumber')->onlyOnForms(),
            TextField::new('address')->onlyOnForms(),
            TextField::new('city')->onlyOnForms(),
            TextField::new('zipCode')->onlyOnForms(),
            TextField::new('country')->onlyOnForms(),
            TextField::new('jobTitle')->onlyOnForms(),

            AssociationField::new('role')->setRequired(true),

            // SERVICE: déclenche render() au changement de sélection
            AssociationField::new('service')
                ->setFormTypeOption('choice_label', 'name')
                ->setFormTypeOption('attr', [
                    'data-service-types-target' => 'serviceSelect',
                    'data-action'               => 'change->service-types#render',
                ]),

            ChoiceField::new('serviceType')
                ->setChoices([])
                ->allowMultipleChoices(true)
                ->renderExpanded(true)
                ->setFormTypeOption('attr', [
                    'data-service-types-target' => 'typeSelect',
                    // plus d'appel automatique ici !
                ]),

            ChoiceField::new('serviceLocation')
                ->setChoices([])
                ->allowMultipleChoices(true)
                ->renderExpanded(true)
                ->setFormTypeOption('attr', [
                    'data-service-types-target' => 'locationSelect',
                    // idem, on retire l'action
                ]),

            ChoiceField::new('status')
                ->setChoices([
                    'Titulaire' => 'Titulaire',
                    'Contractuel' => 'Contractuel',
                    'Stagiaire' => 'Stagiaire',
                ])
                ->allowMultipleChoices(false),

            ChoiceField::new('category')
                ->setChoices([
                    'A' => 'A',
                    'B' => 'B',
                    'C' => 'C',
                ])
                ->allowMultipleChoices(false),

            BooleanField::new('isActive')->renderAsSwitch(),
            BooleanField::new('isVerified')->renderAsSwitch(),
            DateTimeField::new('createdAt')->hideOnForm(),
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof User) {
            return;
        }

        $service = $entityInstance->getService();

        if ($service) {
            $types = $service->getTypes();
            $locations = $service->getLocations();

            if (empty($entityInstance->getServiceType()) && !empty($types)) {
                $entityInstance->setServiceType($types);
            }

            if (empty($entityInstance->getServiceLocation()) && !empty($locations)) {
                $entityInstance->setServiceLocation($locations);
            }
        }

        parent::persistEntity($entityManager, $entityInstance);
    }
}
