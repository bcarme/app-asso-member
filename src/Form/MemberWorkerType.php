<?php

namespace App\Form;

use App\Entity\Member;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class MemberWorkerType extends AbstractType
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
        ->add('dateOfBirth', BirthdayType::class, [
            'label' => 'Date de naissance',
            'format' => 'ddMMMMyyyy',
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
        ->add('cityCode', NumberType::class, [
            'label' => 'Code Postal',
        ])
        ->add('town', TextType::class, [
            'label' => 'Ville',
        ])
        ->add('job', TextType::class, [
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
            'data_class' => Member::class,
        ]);
    }
}
