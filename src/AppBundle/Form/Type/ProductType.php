<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Product;
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

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('name', TextType::class,array(
                'required' => true,
                'label' => 'Add product',
                'attr' => array(
                    'maxlength' => 20,
                    'value' => 'new product',
                    'class' => 'form-control'
                )
            ))
            ->add('cat', TextType::class,array(
                'required' => true,
                'label' => 'Add category',
                'attr' => array(
                    'maxlength' => 20,
                    'value' => 'new category',
                    'class' => 'form-control'
                )
            ))
            ->add('save', SubmitType::class, array('label' => 'Create Category'));

    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Product'
        ));
    }
}