<?php

namespace Apb\TypikaBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

//In order to use service for prePersist and preUpdate
use Symfony\Component\DependencyInjection\ContainerInterface;

use Knp\Menu\ItemInterface as MenuItemInterface;

use Apb\TypikaBundle\Entity\Artefact;

class ArtefactAdmin extends Admin
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
            ->with('Contenu')
                ->add('reference')
                ->add('greek')
                ->add('greek_trans')
                ->add('french')
                ->add('english')
                ->add('context')
                ->add('comments')
                ->add('references')
                ->add('document')
                ->add('category')
                ->add('material')
                ->add('material_2')
                ->add('material_3')
                ->add('synthese')
                ->add('updatedAt')
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
        $formMapper
            ->add('reference')
            ->add('greek')
            ->add('greek_trans')
            ->add('french')
            ->add('english')
            ->add('context', null, array('attr' => array('class' => 'ckeditor')))
            ->add('comments', null, array('attr' => array('class' => 'ckeditor')))
            ->add('references','sonata_type_collection', array('by_reference' => false, 'required' => false, 'label' => 'Comments references'), array(
                    'edit' => 'inline',
                    'inline' => 'table',
                ))
            ->add('document', 'sonata_type_model', array('empty_value' => '---'))
            ->add('category', 'sonata_type_model', array('empty_value' => '---', 'required' => false))
            ->add('material', 'sonata_type_model', array('empty_value' => '---', 'required' => false))
            ->add('material_2', 'sonata_type_model', array('empty_value' => '---', 'required' => false))
            ->add('material_3', 'sonata_type_model', array('empty_value' => '---', 'required' => false))
            ->add('synthese', 'sonata_type_model', array('empty_value' => '---'))
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
            ->add('id')
            ->add('document')
            ->add('reference')
            ->add('greek')
            ->add('greek_trans')
            ->add('french')
            ->add('english')
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
            ->add('reference')
            ->add('document')
            ->add('greek')
            ->add('greek_trans')
            ->add('french')
            ->add('english')
            ->add('material')
            ->add('material_2')
            ->add('material_3')
        ;
    }
}
