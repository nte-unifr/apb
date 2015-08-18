<?php
// src/Apb/TypikaBundle/Menu/Builder.php
namespace Apb\TypikaBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function leftMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem( 'root');

        $menu->addChild( 'Unifr',  array('uri' => 'http://www.unifr.ch/' ) );
        $menu->addChild( 'Centre NTE', array('uri' => 'http://www.unifr.ch/nte/' ) );

        return $menu;
    }

    public function topMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem( 'root');

        $menu->addChild( 'Home', array( 'uri' => '/typika/' ) );
        $menu->addChild( 'Recherche', array( 'route' => 'recherche' ) );
        $menu->addChild( 'Contact', array( 'route' => 'contact' ) );
        $menu->addChild( 'FAQ', array( 'route' => 'faq' ) );

        return $menu;
    }
}
