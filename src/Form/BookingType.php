<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

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
                'label' => 'Titre'])
                ->add('capacity', IntegerType::class, [
                    'label' => 'Nombre de places',
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
