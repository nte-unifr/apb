<?php

namespace Apb\TypikaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\EntityRepository;


class SearchDocument extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Apb\TypikaBundle\Entity\Document',
            'cascade_validation' => true,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            // a unique key to help generate the secret token
            'intention'       => 'search_doc_unique_secret_hahaha',
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('nom', 'entity', array(
            'label' => 'Document',
            'empty_value' => '---------- Selection ----------',
            'class' => 'ApbTypikaBundle:Document',
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('c')
                    ->orderBy('c.nom', 'ASC');
            },
            'required' => true
        ));
    }

    public function getName()
    {
        return 'recherche_document';
    }
}
