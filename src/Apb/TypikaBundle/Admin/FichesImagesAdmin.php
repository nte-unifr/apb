<?php

namespace Apb\TypikaBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Knp\Menu\ItemInterface as MenuItemInterface;

use Apb\TypikaBundle\Entity\FichesImages;

class FichesImagesAdmin extends Admin
{
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('fiche')
            ->add('media', 'sonata_type_model', array('template' => 'ApbTypikaBundle:Fiches:crudimage.html.twig'))
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
     * Create and Edit
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     *
     * @return void
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('media', 'sonata_type_model', array('required' => false), array('link_parameters' => array('context' => 'default', 'provider'=>'sonata.media.provider.image')))
            ->add('fiche')
            ->end()
        ;
    }

    /**

    * {@inheritdoc}

    */

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('media', 'sonata_type_model', array('template' => 'ApbTypikaBundle:Fiches:crudimage.html.twig'))
            ->add('fiche')
            ->end()
        ;
    }
}
