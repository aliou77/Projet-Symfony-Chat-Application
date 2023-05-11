<?php

namespace App\Form;

use App\Entity\Users;
use Liip\ImagineBundle\Form\Type\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fname', TextType::class, [
                'label' => false,
                'attr' =>[
                    'placeholder' => "First Name",
                    'autofocus' => true
                ]
            ])
            ->add('lname', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => "Last Name"
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => "Email",
                    'value' => false
                ]
            ])
            ->add('phone', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => "Phone"
                ]
            ])
            ->add('password', RepeatedType::class, [ // permet de faire duplicaiton du champs pour comfirmer le password
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['id' => 'password']],
                'required' => true,
                'first_options'  => ['label' => false, 'attr' => ['placeholder' => 'Password']],
                'second_options' => ['label' => false, 'attr' => ['placeholder' => 'Comfirm Password']],
            ])
            ->add("imageFile", FileType::class, [
                'label' => "Choose a image profile",
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
