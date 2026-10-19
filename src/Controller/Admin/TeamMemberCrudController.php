<?php

namespace App\Controller\Admin;

use App\Entity\TeamMember;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminRoute;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use Symfony\Component\Validator\Constraints\Image;

#[AdminRoute(path: '/equipe', name: 'team_member')]
final class TeamMemberCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TeamMember::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Membre')
            ->setEntityLabelInPlural("Membres de l'équipe")
            ->setDefaultSort(['position' => 'ASC']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield ImageField::new('photo', 'Photo')
            ->setBasePath('uploads/team')
            ->setUploadDir('public/uploads/team')
            ->setUploadedFileNamePattern('[slug]-[contenthash].[extension]')
            ->setFileConstraints(new Image(maxSize: '2M', mimeTypes: ['image/png', 'image/jpeg', 'image/webp']))
            ->setHelp('PNG, JPG ou WebP, 2 Mo max. Photo carrée de préférence.');
        yield TextField::new('name', 'Nom');
        yield TextField::new('role', 'Rôle');
        yield BooleanField::new('speaker', 'Conférencier·ère')->renderAsSwitch(false);
        yield TextareaField::new('bio', 'Biographie')->hideOnIndex();
        yield UrlField::new('linkedinUrl', 'LinkedIn')->hideOnIndex();
        yield UrlField::new('githubUrl', 'GitHub')->hideOnIndex();
        yield IntegerField::new('position', 'Ordre')->setHelp('Plus petit = affiché en premier.');
    }
}
