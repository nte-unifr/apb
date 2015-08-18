<?php

namespace Apb\TypikaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\EntityRepository;


class SearchSynthese extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Apb\TypikaBundle\Entity\Synthese',
            'cascade_validation' => true,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            // a unique key to help generate the secret token
            'intention'       => 'search_doc_unique_secret_hahaha',
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('greek', 'entity', array(
            'label' => 'Synthese',
            'empty_value' => '---------- Selection ----------',
            'class' => 'ApbTypikaBundle:Synthese',
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('c')
                    ->orderBy('c.greek', 'ASC');
            },
            'required' => true
        ));

        $builder->add('french', 'entity', array(
            'label' => 'Synthese',
            'empty_value' => '---------- Selection ----------',
            'class' => 'ApbTypikaBundle:Synthese',
            'property' => 'french',
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('c')->groupBy('c.french')
                    ->orderBy('c.french', 'ASC');
            },
            'required' => false
        ));

        $builder->add('english', 'entity', array(
            'label' => 'Synthese',
            'empty_value' => '---------- Selection ----------',
            'class' => 'ApbTypikaBundle:Synthese',
            'property' => 'english',
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('c')->groupBy('c.english')
                    ->orderBy('c.english', 'ASC');
            },
            'required' => false
        ));

        $builder->add('definition', 'text', array(
            'label' => 'Keyword',
            'required' => false,
        ));
    }

    public function getName()
    {
        return 'recherche_synthese';
    }
}
