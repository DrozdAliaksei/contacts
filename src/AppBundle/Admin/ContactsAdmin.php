<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 13.3.19
 * Time: 16.07
 */

namespace AppBundle\Admin;

use AppBundle\Entity\ContactsCategory;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ContactsAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add(
                'name',
                TextType::class
            )
            ->add(
                'phoneNumber',
                TelType::class
            )
            ->add(
                'category',
                EntityType::class,
                [
                    'class'        => ContactsCategory::class,
                    'choice_label' => 'categoryName',
                ]
            );
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('phoneNumber');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->addIdentifier('phoneNumber');
    }
}