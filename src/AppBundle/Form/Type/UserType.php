<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormTypeInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->setMethod('POST')

            ->add('username', TextType::class,array(
                'required' => true,
                'label' => 'Login',
                'attr' => array(
                    'maxlength' => 30,
                    'value' => 'bog',
                    'class' => 'form-control'
                )
            ))

            ->add('addre', TextType::class,array(
                'required' => true,
                'label' => 'Address',
                'attr' => array(
                    'maxlength' => 40,
                    'value' => 'some address',
                    'class' => 'form-control'
                )
            ))

            ->add('email', EmailType::class,array(
                'required' => true,
                'attr' => array(
                    'maxlength' => 30,
                    'value' => 'bog@gmail.com',
                    'class' => 'form-control'
                )
            ))

            ->add('country', EntityType::class, array(
                'class' => 'AppBundle:Country',
                'choice_label' => 'name',

            ))

            ->add('password', PasswordType::class,array(
                'required' => true,
                'attr' => array(
                    'maxlength' => 20,
                    'value' => '111111',
                    'class' => 'form-control'
                )
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Create Task',
                'attr' => array(
                    'class' => 'btn btn-success',
                )
            ));

    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }
}