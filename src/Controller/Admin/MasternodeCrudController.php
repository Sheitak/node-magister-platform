<?php

namespace App\Controller\Admin;

use App\Entity\Masternode;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class MasternodeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Masternode::class;
    }

    public function configureFields(string $masternode): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('alias'),
            IntegerField::new('port'),
            TextEditorField::new('private_key'),
            TextEditorField::new('tx_id'),
            IntegerField::new('tx_out'),
            AssociationField::new('cryptocurrency'),
            AssociationField::new('user')
        ];
    }
}
