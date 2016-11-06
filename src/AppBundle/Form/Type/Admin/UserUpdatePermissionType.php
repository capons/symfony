<?php

namespace AppBundle\Form\Type\Admin;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class UserUpdatePermissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('user_role', EntityType::class, array(
                'class' => 'AppBundle:Role',
                'choice_label' => 'role',

            ))

            ->add('id', HiddenType::class)
            ->add('save', SubmitType::class, array(
                'label' => 'Change Role',
                'attr' => array(
                    'class' => 'btn btn-success',
                )
            ));

    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Group'
        ));
    }
}