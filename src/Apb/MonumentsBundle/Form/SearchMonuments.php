<?php

namespace Apb\MonumentsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\EntityRepository;


class SearchMonuments extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Apb\MonumentsBundle\Entity\Monument',
            'cascade_validation' => true,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            // a unique key to help generate the secret token
            'intention'       => 'search_dia_unique_secret_hahaha',
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('section', 'entity', array(
            'label' => 'Section',
            'empty_value' => '---------- Sélection ----------',
            'class' => 'ApbMonumentsBundle:Section',
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('c')
                    ->orderBy('c.name', 'ASC');
            },
            'required' => false
        ));

        $builder->add('chapitre', 'entity', array(
            'label' => 'Chapitre',
            'empty_value' => '---------- Sélection ----------',
            'class' => 'ApbMonumentsBundle:Chapitre',
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('c')
                    ->orderBy('c.name', 'ASC');
            },
            'required' => false
        ));

        $builder->add('categorie', 'entity', array(
            'label' => 'Categorie',
            'empty_value' => '---------- Sélection ----------',
            'class' => 'ApbMonumentsBundle:Categorie',
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('c')
                    ->orderBy('c.name', 'ASC');
            },
            'required' => false
        ));

        $builder->add('pays', 'entity', array(
            'label' => 'Pays',
            'empty_value' => '---------- Sélection ----------',
            'class' => 'ApbMonumentsBundle:Pays',
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('c')
                    ->orderBy('c.name', 'ASC');
            },
            'required' => false
        ));

        $builder->add('lieu', 'entity', array(
            'label' => 'Lieu',
            'empty_value' => '---------- Sélection ----------',
            'class' => 'ApbMonumentsBundle:Lieu',
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('c')
                    ->orderBy('c.name', 'ASC');
            },
            'required' => false
        ));

        $builder->add('iconographie', 'entity', array(
            'label' => 'Iconographie',
            'empty_value' => '---------- Sélection ----------',
            'class' => 'ApbMonumentsBundle:Iconographie',
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('c')
                    ->orderBy('c.name', 'ASC');
            },
            'required' => false
        ));

        $builder->add('monuments', 'entity', array(
            'label' => 'Monuments',
            'empty_value' => '---------- Sélection ----------',
            'class' => 'ApbMonumentsBundle:Monuments',
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('c')
                    ->orderBy('c.name', 'ASC');
            },
            'required' => false
        ));

    }

    public function getName()
    {
        return 'recherche_monument';
    }
}
