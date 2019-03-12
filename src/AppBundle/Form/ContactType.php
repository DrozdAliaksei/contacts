<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 12.3.19
 * Time: 12.47
 */

namespace AppBundle\Form;

use AppBundle\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'constraints' => [new Length(['min' => 2, 'max' => 50]), new NotBlank()],
                    'required'    => true,
                    'label'       => 'Name',
                ]
            )
            ->add(
                'phoneNumber',
                TelType::class,
                [
                    'constraints' => [new Length(['min' => 12, 'max' => 50]), new NotBlank()],
                    'required'    => true,
                    'label'       => 'Phone number',
                ]
            )
            ->add('save', SubmitType::class, ['label' => 'Add contact']);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}