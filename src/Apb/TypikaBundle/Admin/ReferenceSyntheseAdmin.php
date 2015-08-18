<?php

namespace Apb\TypikaBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Knp\Menu\ItemInterface as MenuItemInterface;

use Apb\TypikaBundle\Entity\ReferenceSynthese;

class ReferenceSyntheseAdmin extends Admin
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
                ->add('reference', null, array('label' => 'Number'))
                ->add('synthese')
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
                ->add('reference', null, array('label' => 'Number'))
                ->add('text', null, array( 'attr' => array('class' => 'span12') ))
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
            ->add('reference', null, array('label' => 'Number'))
            ->addIdentifier('synthese')
            ->addIdentifier('text')
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
            ->add('synthese')
            ->add('text')
            ->add('object')
            ->add('id_object')
            ->add('link')
        ;
    }

}
