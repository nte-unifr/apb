<?php

namespace Apb\TypikaBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Knp\Menu\ItemInterface as MenuItemInterface;

use Apb\TypikaBundle\Entity\Reference;

class ReferenceAdmin extends Admin
{
    /**
 * @param \Sonata\AdminBundle\Show\ShowMapper $showMapper
 *
 * @return void
 */
    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->with('Content')
                ->add('position')
                ->add('text')
                ->add('object')
                ->add('id_object')
                ->add('link')
            ->end()
        ;
    }

    /**
 * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
 *
 * @return void
 */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $objects = array('' => '', 'artefact' => 'artefact', 'document' => 'document', 'synthese' => 'synthese');

        $formMapper
            ->with('General')
                ->add('position')
                ->add('text')
                ->add('object', 'choice', array('choices' => $objects))
                ->add('id_object')
                ->add('link', null, array('read_only' => true))
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
            ->add('position')
            ->addIdentifier('text')
            ->add('artefact')
            ->add('object')
            ->add('id_object')
            ->add('link')
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
            ->add('id')
            ->add('text')
            ->add('object')
            ->add('id_object')
            ->add('link')
        ;
    }

}

