<?php

namespace Apb\DiathequeBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Knp\Menu\ItemInterface as MenuItemInterface;

use Apb\DiathequeBundle\Entity\Categorie;

class CategoriesAdmin extends Admin
{
    /**
 * @param \Sonata\AdminBundle\Show\ShowMapper $showMapper
 *
 * @return void
 */
    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
            ->add('categorie')
        ;
    }

    /**
 * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
 *
 * @return void
 */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('categorie')
            ->end()
        ;
    }

    /**
 * @param \Sonata\AdminBundle\Datagrid\ListMapper $listMapper
 *
 * @return void
 */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('categorie')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'view' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
 * @param \Sonata\AdminBundle\Datagrid\DatagridMapper $datagridMapper
 *
 * @return void
 */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('categorie')
        ;
    }

}

