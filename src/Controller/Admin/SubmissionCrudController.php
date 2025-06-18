<?php
// src/Controller/Admin/SubmissionCrudController.php

namespace App\Controller\Admin;

use App\Entity\Submission;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\{
    IdField,
    AssociationField,
    ChoiceField,
    DateTimeField,
    CollectionField,
    FormField
};
use EasyCorp\Bundle\EasyAdminBundle\Filter\{
    ChoiceFilter,
    DateTimeFilter
};

class SubmissionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Submission::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Soumission')
            ->setEntityLabelInPlural('Soumissions')
            ->setDefaultSort(['createdAt' => 'DESC'])
            ->showEntityActionsInlined();
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(ChoiceFilter::new('type')
                ->setChoices([
                    'Mobilité' => 'mobility',
                    'Accès aux outils' => 'access',
                    'Mise en chantier' => 'worksite',
                ]))
            ->add(ChoiceFilter::new('status')
                ->setChoices([
                    'En attente' => 'pending',
                    'Validée'    => 'approved',
                    'Refusée'    => 'rejected',
                ]))
            ->add(DateTimeFilter::new('createdAt'));
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->onlyOnIndex(),

            FormField::addPanel('🔍 Informations générales'),

            AssociationField::new('agent', 'Agent')
                ->onlyOnForms()
                ->setRequired(true),

            AssociationField::new('filledBy', 'Rempli par')
                ->onlyOnForms(),

            ChoiceField::new('type', 'Type de formulaire')
                ->setChoices([
                    'Mobilité'         => 'mobility',
                    'Accès aux outils' => 'access',
                    'Mise en chantier' => 'worksite',
                ])
                ->renderAsBadges()
                ->onlyOnForms(),

            ChoiceField::new('status', 'Statut')
                ->setChoices([
                    'En attente' => 'pending',
                    'Validée'    => 'approved',
                    'Refusée'    => 'rejected',
                ])
                ->renderAsBadges()
                ->onlyOnForms(),

            DateTimeField::new('createdAt', 'Soumis le')
                ->onlyOnIndex(),

            FormField::addPanel('📄 Contenu'),

            CollectionField::new('answers', 'Réponses')
                ->onlyOnDetail()
                ->setTemplatePath('admin/fields/submission_answers.html.twig'),

            CollectionField::new('documents', 'Pièces jointes')
                ->onlyOnDetail()
                ->setTemplatePath('admin/fields/submission_documents.html.twig'),

            CollectionField::new('validationSteps', 'Étapes de validation')
                ->onlyOnDetail(),
        ];
    }
}
