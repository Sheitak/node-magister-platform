<?php

namespace App\Form;

use App\Entity\CryptocurrencySearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CryptocurrencySearchType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('consensus', ChoiceType::class, [
                'required' => false,
                'label' => false,
                'placeholder' => 'Choose Consensus',
                'choices' => [
                    'POW' => 'POW',
                    'POS' => 'POS',
                    'POW/POS' => 'POW/POS',
                    'DPOS' => 'DPOS',
                    'PBFT' => 'PBFT',
                ]
            ])
            ->add('minCollateral', IntegerType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Minimum Collateral'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CryptocurrencySearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
