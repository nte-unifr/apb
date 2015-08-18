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

use Apb\TypikaBundle\Entity\Document;

class DocumentAdmin extends Admin
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
                ->add('nom')
                ->add('biblio')
                ->add('authority')
                ->add('type')
                ->add('date')
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
            ->add('nom')
            ->add('biblio')
            ->add('authority')
            ->add('type')
            ->add('date')
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
            ->add('nom')
            ->add('biblio')
            ->add('authority')
            ->add('type')
            ->add('date')
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
            ->add('nom')
            ->add('biblio')
            ->add('authority')
            ->add('type')
            ->add('date')
        ;
    }
}
