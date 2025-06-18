<?php
// src/Controller/Admin/QuestionCrudController.php

namespace App\Controller\Admin;

use App\Entity\Question;
use App\Repository\QuestionRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\{
    ChoiceField,
    TextField,
    TextareaField,
    BooleanField,
    IntegerField,
    AssociationField,
    FormField
};
use EasyCorp\Bundle\EasyAdminBundle\Filter\{
    ChoiceFilter,
    BooleanFilter
};

class QuestionCrudController extends AbstractCrudController
{
    public function __construct(
        private readonly QuestionRepository $questionRepo
    ) {}

    public static function getEntityFqcn(): string
    {
        return Question::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Question')
            ->setEntityLabelInPlural('Questions')
            ->setDefaultSort(['submissionType' => 'ASC', 'orderIndex' => 'ASC'])
            ->showEntityActionsInlined()
            ->setSearchFields(['label', 'submissionType', 'type']);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(ChoiceFilter::new('submissionType')
                ->setChoices($this->questionRepo->getMockSubmissionTypes()))
            ->add(ChoiceFilter::new('type')
                ->setChoices($this->questionRepo->getTypeChoices()))
            ->add(BooleanFilter::new('required'));
    }

    public function configureFields(string $pageName): iterable
    {
        $mockTypes  = $this->questionRepo->getMockSubmissionTypes();
        $fieldTypes = $this->questionRepo->getTypeChoices();

        return [
            FormField::addPanel('🔧 Données de base'),

            ChoiceField::new('submissionType', 'Formulaire')
                ->setChoices($mockTypes)
                ->renderAsBadges()
                ->onlyOnForms(),

            TextField::new('label', 'Intitulé'),

            ChoiceField::new('type', 'Type de champ')
                ->setChoices($fieldTypes)
                ->renderAsBadges(),

            BooleanField::new('required', 'Obligatoire'),

            IntegerField::new('orderIndex', 'Ordre'),

            TextareaField::new('options', 'Options (JSON)')
                ->onlyOnForms()
                ->hideOnIndex()
                ->setHelp('Entrez un JSON valide, ex. ["A","B","C"]'),

            FormField::addPanel('🔗 Conditions'),

            AssociationField::new('dependsOnQuestion', 'Dépend de')
                ->setFormTypeOption(
                    'query_builder',
                    fn() => $this->questionRepo
                        ->createQueryBuilder('q')
                        ->orderBy('q.label', 'ASC')
                )
                ->setRequired(false),

            TextField::new('dependsOnValue', 'Valeur déclenchante')
                ->setRequired(false),
        ];
    }
}
