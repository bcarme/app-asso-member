<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\Category;
use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('beginAt', DateTimeType::class, [
                'label' => 'Début',
                'choice_translation_domain' => true,
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y')+4),
                ])
            ->add('endAt', DateTimeType::class, [
                'label' => 'Fin',
                'choice_translation_domain' => true,
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y')+4),
                ])
            ->add('title', TextType::class, [
                'label' => 'Titre'
                ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'theme',
                'label' => 'Catégorie',
                ])
            ->add('location', EntityType::class, [
                    'class' => Location::class,
                    'choice_label' => 'place',
                    'label' => 'Lieu',
                    ])     
            ->add('capacity', IntegerType::class, [
                    'label' => 'Nombre de places',
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
