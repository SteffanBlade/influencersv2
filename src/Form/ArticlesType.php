<?php

namespace App\Form;

use App\Entity\Articles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ArticlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', File::class, array('label' => 'Images'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Articles::class
        ));
    }

}