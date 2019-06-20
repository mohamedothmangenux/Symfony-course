<?php

namespace AppBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class CheckAddressForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('FirmName')
            ->add('Apt')
            ->add('Address')
            ->add('City')
            ->add('State')
            ->add('Zip5')
            ->add('Zip4')
        ;
    }
}