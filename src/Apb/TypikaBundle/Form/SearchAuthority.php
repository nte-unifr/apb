<?php

namespace Apb\TypikaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\EntityRepository;


class SearchAuthority extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Apb\TypikaBundle\Entity\Document',
            'cascade_validation' => true,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            // a unique key to help generate the secret token
            'intention'       => 'search_doac_unique_secret_hahaha',
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('authority', 'entity', array(
            'label' => 'Authority',
            'empty_value' => '---------- Selection ----------',
            'class' => 'ApbTypikaBundle:Authority',
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('c')
                    ->orderBy('c.nom', 'ASC');
            },
            'required' => false
        ));

        $builder->add('type', 'entity', array(
            'label' => 'DocumentType',
            'empty_value' => '---------- Selection ----------',
            'class' => 'ApbTypikaBundle:DocumentType',
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('c')
                    ->orderBy('c.nom', 'ASC');
            },
            'required' => false
        ));
    }

    public function getName()
    {
        return 'recherche_authority';
    }
}
