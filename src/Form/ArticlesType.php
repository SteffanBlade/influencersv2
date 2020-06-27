<?php


namespace App\Form;

use App\Entity\Articles;
use App\Entity\Authors;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ArticlesType extends AbstractType
{
public function buildForm(FormBuilderInterface $builder, array $options)
{
$builder->add('title')
        ->add('content')
        ->add('tags');

    $builder->add('Authors', EntityType::class);
}

public function configureOptions(OptionsResolver $resolver)
{
$resolver->setDefaults([
'data_class' => Articles::class,
]);
}
}