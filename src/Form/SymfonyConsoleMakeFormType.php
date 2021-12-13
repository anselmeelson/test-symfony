<?php

namespace App\Form;

use App\Entity\Transfert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SymfonyConsoleMakeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('full_name')
            ->add('bank_name')
            ->add('iban')
            ->add('code_swift')
            ->add('amount')
            ->add('pays')
            ->add('user_client')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Transfert::class,
        ]);
    }
}
