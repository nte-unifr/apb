<?php

namespace Apb\TypikaBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Knp\Menu\ItemInterface as MenuItemInterface;

use Apb\TypikaBundle\Entity\Category;

class CategoriesAdmin extends Admin
{
    /**
     * Default Datagrid values
     *
     * @var array
     */
    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'ASC',
        '_sort_by' => 'nom'
    );

    /**
 * @param \Sonata\AdminBundle\Show\ShowMapper $showMapper
 *
 * @return void
 */
    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
            ->add('nom')
            ->add('nom2')
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
                ->add('nom')
                ->add('nom2')
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
            ->addIdentifier('nom')
            ->add('nom2')
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
            ->add('nom')
            ->add('nom2')
        ;
    }

}

