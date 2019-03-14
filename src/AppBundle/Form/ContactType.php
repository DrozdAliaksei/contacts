<?php

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

/**
 * Class ContactType
 * @package AppBundle\Form
 */
class ContactType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
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
                    'constraints' => [new Length(['min' => 3, 'max' => 12]), new NotBlank()],
                    'required'    => true,
                    'label'       => 'Phone number',
                    'attr'        => ['pattern' => "[0-9]{3,12}"],
                ]
            )
            ->add('save', SubmitType::class, ['label' => 'Add contact']);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Contact::class,
            ]
        );
    }
}