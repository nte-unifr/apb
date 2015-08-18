<?php

namespace Apb\DiathequeBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

//In order to use service for prePersist and preUpdate
use Symfony\Component\DependencyInjection\ContainerInterface;

use Knp\Menu\ItemInterface as MenuItemInterface;

use Apb\DiathequeBundle\Entity\Dia;

class DiaAdmin extends Admin
{

    protected $securityContext;

    public function __construct($code, $class, $baseControllerName, ContainerInterface $container)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->container = $container;
    }

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
                ->add('fiche')
                ->add('description')
                ->add('monument')
                ->add('motsCles')
                ->add('reference')
                ->add('selection')
                ->add('categorie1')
                ->add('categorie2')
                ->add('nbCouleur')
                ->add('image', null, array('template' => 'ApbDiathequeundle::media.html.twig'))
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
                ->add('fiche')
                ->add('description')
                ->add('monument')
                ->add('motsCles')
                ->add('reference')
                ->add('selection', null, array('required' => false))
                ->add('categorie1')
                ->add('categorie2')
                ->add('nbCouleur')
            ->with('Medias')
                ->add('image', 'sonata_type_model_list', array('required' => false), array('link_parameters' => array('context' => 'diatheque', 'provider'=>'sonata.media.provider.image')))
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
            ->add('id')
            ->add('fiche')
            ->add('description')
            ->add('selection')
            ->add('categorie1')
            ->add('nbCouleur')
            ->add('image', 'sonata_type_model', array('template' => 'ApbDiathequeBundle::crudimage.html.twig'))
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
                ->add('fiche')
                ->add('description')
                ->add('monument')
                ->add('motsCles')
                ->add('reference')
                ->add('selection')
                ->add('categorie1')
                ->add('categorie2')
                ->add('nbCouleur')
        ;
    }
}
