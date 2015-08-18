<?php

namespace Apb\DiathequeBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Knp\Menu\ItemInterface as MenuItemInterface;

use Apb\DiathequeBundle\Entity\Nbcouleur;

class NbcouleurAdmin extends Admin
{
    /**
 * @param \Sonata\AdminBundle\Show\ShowMapper $showMapper
 *
 * @return void
 */
    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
            ->add('nbcouleur')
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
                ->add('nbcouleur')
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
            ->addIdentifier('nbcouleur')
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
            ->add('nbcouleur')
        ;
    }
}

