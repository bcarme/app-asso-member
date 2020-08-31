<?php

namespace App\Form;

use App\Entity\Worker;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class WorkerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('firstname', TextType::class, [
            'label' => 'Prénom',
        ])
        ->add('lastname', TextType::class, [
            'label' => 'Nom',
        ])
        ->add('email', EmailType::class, [
            'label' => 'Email',
        ])
        ->add('phone', TextType::class, [
            'label' => 'Téléphone',
        ])
        ->add('address', TextType::class, [
            'label' => 'Adresse',
        ])
        ->add('zipCode', NumberType::class, [
            'label' => 'Code Postal',
        ])
        ->add('town', TextType::class, [
            'label' => 'Ville',
        ])
        ->add('jobType', TextType::class, [
            'label' => 'Fonction',
        ])
        ->add('imageFile', VichImageType::class, [
            'required' => false,
            'allow_delete' => false,
            'download_uri' => false,
            'image_uri' => true,
            'asset_helper' => true,
            'label' => 'Photo',
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Worker::class,
        ]);
    }
}
