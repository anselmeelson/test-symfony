<?php

namespace App\Form;

use App\Entity\UserClient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            ->add('nom')
            ->add('prenom')
            ->add('date_at')
            ->add('pays')
            ->add('email')
            ->add('numero')
            ->add('profession')
            ->add('device')
            ->add('created_at')
            ->add('password')
            ->add('solde')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserClient::class,
        ]);
    }
}
