<?php

namespace App\Form;

use App\Entity\Cryptocurrency;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class CryptocurrencyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('ticker')
            ->add('consensus', ChoiceType::class, [
                'choices' => [
                    'POW' => 'POW',
                    'POS' => 'POS',
                    'POW/POS' => 'POW/POS',
                    'DPOS' => 'DPOS',
                ]
            ])
            ->add('collateral')
            ->add('imageFile', FileType::class, [
                'required' => false,
                'label' => 'Add Image File',
                'attr' => [
                    'placeholder' => 'Search Your Image'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cryptocurrency::class,
        ]);
    }
}
