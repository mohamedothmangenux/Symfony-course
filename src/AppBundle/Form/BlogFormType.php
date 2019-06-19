<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Repository\CategoryRepository;

class BlogFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
            ])
            ->add('postedAt', DateType::class ,[
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker'],
                'html5' => false,

            ])
            ->add('status', ChoiceType::class, [
                'choices'  => [
                    'Please Select Status' => null,
                    'Publish' => true,
                    'UnPublish' => false,
                ],
            ]);

            // ->add('category',null, [
            //     'placeholder' => 'Choose a Category'
            // ]);
            $builder->add('category', EntityType::class, [
                'class' => 'AppBundle:Category',
                'query_builder' => function(CategoryRepository $repo) {
                    return $repo->createAlphabeticalQueryBuilder();
                }
            ]);

            
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
               'data_class' => 'AppBundle\Entity\Post'
            ]);
        
    }

}