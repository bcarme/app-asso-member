<?php

namespace App\Form;

use App\Entity\Member;
use App\Entity\Registration;
use App\Repository\MemberRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class BookingRegistrationType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $this->security->getUser();
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
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
                'label' => 'Inscrire l\'adhérent',
                'by_reference' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Registration::class,
        ]);
    }
}
