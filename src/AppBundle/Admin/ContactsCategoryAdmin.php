<?php

namespace AppBundle\Admin;

use AppBundle\Entity\ContactsCategory;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\AdminInterface;

/**
 * Class ContactsCategoryAdmin
 * @package AppBundle\Admin
 */
class ContactsCategoryAdmin extends AbstractAdmin
{
    /**
     * @param MenuItemInterface   $menu
     * @param                     $action
     * @param AdminInterface|null $childAdmin
     *
     * @return mixed|void
     */
    protected function configureTabMenu(
        MenuItemInterface $menu,
        $action,
        AdminInterface $childAdmin = null
    ) //TODO understand
        // difference between SideMenu and TabMenu
    {
        if (!$childAdmin && !in_array($action, ['edit', 'show'])) {
            return;
        }
        $admin = $this->isChild() ? $this->getParent() : $this;
        $id = $admin->getRequest()->get('id');
        $contactAdmin = $this->getChild('admin.contacts');
        $menu->addChild(
            'View Category',
            [
                'uri' => $admin->generateUrl('show', ['id' => $id]),
            ]
        );
        if ($this->isGranted('EDIT')) {
            $menu->addChild(
                'Edit Category',
                [
                    'uri' => $admin->generateUrl('edit', ['id' => $id]),
                ]
            );
        }
        if ($contactAdmin->isGranted('LIST')) {
            $menu->addChild(
                'Manage Contacts',
                [
                    'uri' => $contactAdmin->generateUrl('list'),
                ]
            );
        }
    }

    /**
     * @param ShowMapper $show
     */
    protected function configureShowFields(ShowMapper $show)
    {
        $show->add('categoryName');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('categoryName', TextType::class);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('categoryName');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('categoryName')
            ->add(
                '_action',
                'actions',
                [
                    'actions' => [
                        'show'   => [],
                        'edit'   => [],
                        'delete' => [],
                    ],
                ]
            );
    }

    /**
     * @param $object
     *
     * @return mixed|string
     */
    public function toString($object)
    {
        return $object instanceof ContactsCategory
            ? $object->getCategoryName()
            : 'Contact';
    }
}