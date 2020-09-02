<?php

namespace App\Form;

use App\Entity\Member;
use App\Entity\OnlineForm;
use App\Repository\MemberRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class OnlineFormType extends AbstractType
{
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $this->security->getUser();
        $builder
            ->add('parentName', TextType::class, [
                'label' => 'Je soussigné(e):',
                'attr' => array(
                'placeholder' => 'Nom du parent'
                )
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('hasAgreedConduct', ChoiceType::class, [
                'label' => 'J\'ai lu et j\'accepte la charte de bonne conduite',
                'choices'  => [
                    'Oui' => true,
                    'Non' => false,
                ],
            ])
            ->add('hasAgreedTransportation', ChoiceType::class, [
                'label' => 'Déplacement',
                'choices'  => [
                    'Oui' => true,
                    'Non' => false,
                ],
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => false,
                'download_uri' => false,
                'image_uri' => true,
                'asset_helper' => true,
                'label' => 'Signature',
            ])
            ->add('member', EntityType::class, [
                'class' => Member::class,
                'query_builder' => function (MemberRepository $er) use ($user) {
                    return $er->createQueryBuilder('u')
                        ->where('u.user = :id')
                        ->setParameter('id', $user)
                        ->orderBy('u.firstname', 'ASC');
                },
                'choice_label' => 'fullname',
                'label' => 'Choisir l\'adhérent',
                'by_reference' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OnlineForm::class,
        ]);
    }
}
