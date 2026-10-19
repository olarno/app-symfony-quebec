<?php

namespace App\Controller\Admin;

use App\Entity\Sponsor;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminRoute;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use Symfony\Component\Validator\Constraints\Image;

#[AdminRoute(path: '/commanditaires', name: 'sponsor')]
final class SponsorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Sponsor::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Commanditaire')
            ->setEntityLabelInPlural('Commanditaires')
            ->setDefaultSort(['tier' => 'ASC', 'position' => 'ASC']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield ImageField::new('logo', 'Logo')
            ->setBasePath('uploads/sponsors')
            ->setUploadDir('public/uploads/sponsors')
            ->setUploadedFileNamePattern('[slug]-[contenthash].[extension]')
            ->setFileConstraints(new Image(maxSize: '2M', mimeTypes: ['image/png', 'image/jpeg', 'image/webp']))
            ->setHelp('PNG, JPG ou WebP, 2 Mo max. Fond transparent recommandé.');
        yield TextField::new('name', 'Nom');
        yield ChoiceField::new('tier', 'Palier');
        yield UrlField::new('websiteUrl', 'Site web');
        yield TextareaField::new('description', 'Description')->hideOnIndex();
        yield IntegerField::new('position', 'Ordre')->setHelp("Plus petit = affiché en premier dans son palier.");
    }
}
