<?php

namespace App\Form;

use App\Entity\Masternode;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MasternodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('alias')
            ->add('ip')
            ->add('port')
            ->add('private_key')
            ->add('tx_id')
            ->add('tx_out')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Masternode::class,
        ]);
    }
}
