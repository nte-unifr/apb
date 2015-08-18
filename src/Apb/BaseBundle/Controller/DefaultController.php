<?php

namespace Apb\BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $page = $em->getRepository('ApbBaseBundle:Pages')->find(1);
        return array('page' => $page);
    }

    /**
     * @Route("/bibliographies/")
     * @Template()
     */
    public function bibliographiesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $page = $em->getRepository('ApbBaseBundle:Pages')->find(2);

        return $this->render(
            'ApbBaseBundle:Default:index.html.twig',
            array(
                'page' => $page
                )
        );
    }
}
