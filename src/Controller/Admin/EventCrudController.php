<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminRoute;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

#[AdminRoute(path: '/evenements', name: 'event')]
final class EventCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Event::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Événement')
            ->setEntityLabelInPlural('Événements')
            ->setDefaultSort(['startsAt' => 'DESC'])
            ->setSearchFields(['title', 'city', 'venue']);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters->add('type')->add('startsAt');
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title', 'Titre');
        yield SlugField::new('slug', 'Slug (URL)')->setTargetFieldName('title')->hideOnIndex();
        yield ChoiceField::new('type', 'Type');
        yield DateTimeField::new('startsAt', 'Date et heure');
        yield TextField::new('city', 'Ville');
        yield TextField::new('venue', 'Lieu')->hideOnIndex();
        yield BooleanField::new('online', 'En ligne')->renderAsSwitch(false);
        yield TextareaField::new('description', 'Description')->hideOnIndex();
        yield UrlField::new('registrationUrl', "Lien d'inscription")->hideOnIndex();
    }
}
