<?php

namespace Apb\DiathequeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\EntityRepository;


class AdvancedSearchDia extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Apb\DiathequeBundle\Entity\Dia',
            'cascade_validation' => true,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            // a unique key to help generate the secret token
            'intention'       => 'search_dia_unique_secret_hahaha',
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('fiche',       'text', array('required' => false, 'label' => 'Fiche n°'));

        $builder->add('categorie1', 'entity', array(
            'label' => 'Catégorie 1',
            'class' => 'ApbDiathequeBundle:Categorie',
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('c')
                    ->orderBy('c.categorie', 'ASC');
            },
            'required' => true
        ));

        $builder->add('categorie2', 'entity', array(
            'label' => 'Catégorie 2',
            'class' => 'ApbDiathequeBundle:Categorie',
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('c')
                    ->orderBy('c.categorie', 'ASC');
            },
            'required' => true
        ));

        $builder->add('monument',   'text', array('required' => false, 'label' => 'Monuments'));

        $builder->add('description', 'text', array('required' => false, 'label' => 'Description'));

        $builder->add('nb_couleur', 'entity', array(
            'label' => 'Nb couleur',
            'class' => 'ApbDiathequeBundle:Nbcouleur',
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('n')
                    ->orderBy('n.nbcouleur', 'ASC');
            },
            'required' => true
        ));

        $builder->add('reference',   'text', array('required' => false, 'label' => 'Référence'));
    }

    public function getName()
    {
        return 'recherche_dia';
    }
}
