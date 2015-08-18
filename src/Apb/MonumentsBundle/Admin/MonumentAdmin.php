<?php

namespace Apb\MonumentsBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

//In order to use service for prePersist and preUpdate
use Symfony\Component\DependencyInjection\ContainerInterface;

use Knp\Menu\ItemInterface as MenuItemInterface;

use Apb\MonumentsBundle\Entity\Monument;

class MonumentAdmin extends Admin
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
                ->add('section')
                ->add('chapitre')
                ->add('categorie')
                ->add('pays')
                ->add('lieu')
                ->add('monuments')
                ->add('iconographie')
                ->add('date')
                ->add('notices')
                ->add('url')
                ->add('siecle')
                ->add('images', null, array('label' => 'Images annexes', 'template' => 'ApbTypikaBundle::media_many.html.twig'))
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
#            ->add('id')
            ->add('section','sonata_type_model', array('empty_value' => '--- Choisir ---'))
            ->add('chapitre','sonata_type_model', array('empty_value' => '--- Choisir ---'))
            ->add('categorie','sonata_type_model', array('empty_value' => '--- Choisir ---'))
            ->add('pays','sonata_type_model', array('empty_value' => '--- Choisir ---'))
            ->add('lieu','sonata_type_model', array('empty_value' => '--- Choisir ---'))
            ->add('monuments','sonata_type_model', array('empty_value' => '--- Choisir ---'))
            ->add('iconographie','sonata_type_model', array('empty_value' => '--- Choisir ---'))
            ->add('date')
            ->add('notices')
            ->add('url')
            ->add('siecle')
            ->with('Medias')
                ->add('images','sonata_type_collection', array('label' => 'Images annexes', 'by_reference' => false, 'required' => false, 'help' => '<hr /><strong>Aide pour le statut de l\'image:</strong><br /><ul> 0 = on ne prend pas l\'image pour les exercices<br />1 = on prend les images pour le 1er cours<br />2 = on prend les images pour le 2eme cours</ul>'), array(
                        'edit' => 'inline',
                        'inline' => 'table',
                    ))
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
#            ->add('section')
            ->add('chapitre')
            ->add('categorie')
            ->add('pays')
            ->add('lieu')
            ->add('monuments')
            ->add('date')
            ->add('siecle')
            //->add('image', 'sonata_type_model', array('template' => 'ApbDiathequeBundle::crudimage.html.twig'))
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
            ->add('section')
            ->add('chapitre')
            ->add('categorie')
            ->add('pays')
            ->add('lieu')
            ->add('monuments')
            ->add('iconographie')
            ->add('date')
            ->add('notices')
            ->add('siecle')
        ;
    }
}
