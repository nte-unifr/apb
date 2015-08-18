<?php

namespace Apb\TypikaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
//use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Sonata\AdminBundle\Security\Acl\Permission\MaskBuilder;

use Apb\TypikaBundle\Entity\Artefact;
use Apb\TypikaBundle\Form\SearchArtefact;

use Apb\TypikaBundle\Entity\Authority;
use Apb\TypikaBundle\Entity\Document;
use Apb\TypikaBundle\Entity\DocumentType;
use Apb\TypikaBundle\Entity\Synthese;
use Apb\TypikaBundle\Form\SearchAuthority;
use Apb\TypikaBundle\Form\SearchDocument;
use Apb\TypikaBundle\Form\SearchSynthese;

use Symfony\Component\HttpFoundation\Response;

class ConvertController extends Controller
{
    /**
     * @Route("/convertReference")
     * @Template()
     */
    public function convertReferenceAction()
    {
        # à commenter pour exécuter la migration des liens
        return new Response('<html><body><h1>EXIT!</h1></body></html>');
        exit();

        $em = $this->getDoctrine()->getManager();

        $references = $em->getRepository('ApbTypikaBundle:Reference')->findAll();
        
        foreach ($references as $ref) {
            print_r($ref->getId() . ' - ' . $ref->getLink().'<br>');
            $link = explode('http://elearning.unifr.ch/apb/Typika/fiche_', $ref->getLink());
            if ( count($link) > 1 ) {
                $tmp = explode('.', $link[1]);
                $object = $tmp[0];
                $tmp = explode('=', $link[1]);
                $id = $tmp[1];
                $ref->setObject($object);
                $ref->setIdObject($id);
                $em->persist($ref);
                print_r($object.', id: '.$id.'<br>');
            }
        }
        $em->flush();

        $referencesSyntheses = $em->getRepository('ApbTypikaBundle:ReferenceSynthese')->findAll();
        
        foreach ($referencesSyntheses as $ref) {
            print_r($ref->getId() . ' - ' . $ref->getLink().'<br>');
            $link = explode('http://elearning.unifr.ch/apb/Typika/fiche_', $ref->getLink());
            if ( count($link) > 1 ) {
                $tmp = explode('.', $link[1]);
                $object = $tmp[0];
                $tmp = explode('=', $link[1]);
                $id = $tmp[1];
                $ref->setObject($object);
                $ref->setIdObject($id);
                $em->persist($ref);
                print_r($object.', id: '.$id.'<br>');
            }
        }
        $em->flush();

        return new Response('<html><body><h1>Conversion terminée!</h1></body></html>');
    }




}
