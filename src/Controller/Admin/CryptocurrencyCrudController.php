<?php

namespace App\Controller\Admin;

use App\Entity\Cryptocurrency;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CryptocurrencyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Cryptocurrency::class;
    }

    public function configureFields(string $cryptocurrency): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('name'),
            TextField::new('ticker'),
            TextField::new('consensus'),
            IntegerField::new('collateral'),
            ImageField::new('imageFile')->setFormType(VichImageType::class)->setLabel('logo'),
            DateTimeField::new('updatedAt'),
            AssociationField::new('masternodes')->onlyOnIndex()
        ];
    }
}
