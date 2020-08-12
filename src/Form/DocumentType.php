<?php

namespace App\Form;

use App\Entity\Member;
use App\Entity\Document;
use App\Repository\MemberRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class DocumentType extends AbstractType
{
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $this->security->getUser();
        $builder
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => false,
                'download_uri' => false,
                'image_uri' => true,
                'asset_helper' => true,
                'label' => 'Attestation médicale',
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
            'data_class' => Document::class,
        ]);
    }
}
