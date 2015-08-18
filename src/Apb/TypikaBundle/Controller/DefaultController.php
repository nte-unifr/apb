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

use Symfony\Component\Security\Acl\Domain\RoleSecurityIdentity;
use Symfony\Component\HttpFoundation\Response;

use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Exception\NotValidCurrentPageException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    /**
     * @Route("/", defaults={"id" = 1})
     * @Route("/page/{id}", defaults={"id" = 1})
     * @Template()
     */
    public function indexAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $page = $em->getRepository('ApbTypikaBundle:Pages')->find($id);

        $news = $em->getRepository('ApbTypikaBundle:Actualites')->findBy(array(), array('date' => 'DESC'), 5);
#        $news = count($news) > 0 ? $news[0] : null;

        return array('titre' => 'Page d\'accueil',
                     'page' => $page,
                     'news' => $news);
    }

    /**
     * @Route("/news/{id}", defaults={"id" = 1})
     * @Template()
     */
    public function actualiteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $actualite = $em->getRepository('ApbTypikaBundle:Actualites')->find($id);
        return array('titre' => 'News',
                     'actualite' => $actualite);
    }

    /**
     * @Route("/archives/{page}", defaults={"page" = 1})
     * @Template()
     */
    public function archivesAction($page)
    {

        $em = $this->getDoctrine()->getManager();

        $actu = $em->getRepository('ApbTypikaBundle:Actualites');

        $query = $actu->createQueryBuilder( 'a' )
                     ->orderBy( 'a.date', 'DESC' )
                     ->addOrderBy( 'a.id', 'DESC' );
        $all_actualites = $query->getQuery()->getResult();

        $query->setFirstResult( ($page - 1) * 20 )
              ->setMaxResults( 20 );
        $actualites = $query->getQuery()->getResult();

        # pager
        $adapter  = new DoctrineORMAdapter($query);
        $pager    = new PagerFanta($adapter);
        $pager->setMaxPerPage(20);
        try {
            $pager->setCurrentPage($page);
        } catch (NotValidCurrentPageException $e) {
            throw new NotFoundHttpException();
        }

        return array('titre' => 'News',
                     'actualites' => $actualites,
                     'pager'    => $pager);
    }

    /**
     * @Route("/search")
     */
    public function searchAction()
    {
        $session = $this->getRequest()->getSession();
        $object = $session->get('last_request_type') ? $session->get('last_request_type') : 'artefact';

        $url = $this->generateUrl(
            'apb_typika_default_' . $object . 'search'
        );
        return $this->redirect($url);
    }


    /**
     * @Route("/artefactsearch/{page}/{all}")
     */
    public function artefactSearchAction($page = 1, $all = false)
    {
        $session = $this->getRequest()->getSession();

        $pager = null;
        $ids = array();

        $em = $this->getDoctrine()->getManager();
        $art = $em->getRepository('ApbTypikaBundle:Artefact');

        $document = $em->getRepository('ApbTypikaBundle:Document')
                       ->findBy(array(), array('nom' => 'asc'));

        $greek = $art->createQueryBuilder('a')
                     ->select('a.greek AS nom')
                     ->orderBy('nom', 'ASC')
                     ->groupBy('nom')
                     ->getQuery()->getResult();

        $greek_trans = $art->createQueryBuilder('a')
                           ->select('DISTINCT(a.greek_trans) AS nom')
                           ->orderBy('nom', 'ASC')
                           ->groupBy('nom')
                           ->getQuery()->getResult();

        $french = $art->createQueryBuilder('a')
                      ->select('DISTINCT(a.french) AS nom')
                      ->orderBy('nom', 'ASC')
                      ->groupBy('nom')
                      ->getQuery()->getResult();

        $english = $art->createQueryBuilder('a')
                       ->select('DISTINCT(a.english) AS nom')
                       ->orderBy('nom', 'ASC')
                       ->groupBy('nom')
                       ->getQuery()->getResult();

#        $categories = $em->getRepository('ApbTypikaBundle:Category')
#                         ->findBy(array(), array('nom' => 'asc'));

        $categories = $em->getRepository('ApbTypikaBundle:Category')
                       ->createQueryBuilder('c')
                       ->select('DISTINCT(c.nom) AS nom')
                       ->orderBy('nom', 'ASC')
                       ->groupBy('nom')
                       ->getQuery()->getResult();

        $materials = $em->getRepository('ApbTypikaBundle:Material')
                        ->findBy(array(), array('nom' => 'asc'));

        if ($session->has('request_artefact')) {
            $data = $session->get('request_artefact');
        } else {
            $data = array();
        }

        $artefacts = array();
        #***********************************************
        $request = $this->get('request');

        if( $all && 'POST' != $request->getMethod() ) {
            $resultat = true;
            $query = $art->createQueryBuilder( 'a' )
                         ->orderBy( 'a.greek', 'ASC' );

            $all_artefacts = $query->select('a.id')->getQuery()->getArrayResult();
#            $ids = array_column($all_artefacts, 'id');
            $ids = array_map('current', $all_artefacts);
#            $ids = array();
#            foreach($all_artefacts as $artefact) {
#                array_push($ids, $artefact->getId());
#            }
            $query->select('a'); # pour avoir les objets, et pas seulement les id
            $query->setFirstResult( ($page - 1) * 20 )
                  ->setMaxResults( 20 );
            $artefacts = $query->getQuery()->getResult();
            $session->set('recherche_artefact_ids', $ids);
            $session->set('request_artefact', null);
            $data = array();

            # pager
            $adapter  = new DoctrineORMAdapter($query);
            $pager    = new PagerFanta($adapter);
            $pager->setMaxPerPage(20);
            try {
                $pager->setCurrentPage($page);
            } catch (NotValidCurrentPageException $e) {
                throw new NotFoundHttpException();
            }
        }

        if( !$all && $session->has('recherche_artefact_ids') && 'POST' != $request->getMethod() ) {
            $ids = $session->get('recherche_artefact_ids');
#            $form->bind($session->get('recherche_artefact_ids'));
            $resultat = true;
            $query = $art->createQueryBuilder( 'a' );

            if ( count($ids) > 0 ) {
                $query
                    ->where('a.id IN (:ids)')
                        ->setParameter( 'ids',$ids )
                    ->orderBy( 'a.greek', 'ASC' )
                    ->setFirstResult( ($page - 1) * 20 )
                    ->setMaxResults( 20 );
                $artefacts = $query->getQuery()->getResult();

                # pager
                $adapter  = new DoctrineORMAdapter($query);
                $pager    = new PagerFanta($adapter);
                $pager->setMaxPerPage(20);
                try {
                    $pager->setCurrentPage($page);
                } catch (NotValidCurrentPageException $e) {
                    throw new NotFoundHttpException();
                }
            }
        }

        if( !$all && 'POST' == $request->getMethod() ) {
            // On récupère le repository
            $repository = $this->getDoctrine()->getManager()->getRepository( 'ApbTypikaBundle:Artefact' );

            $qb = $repository->createQueryBuilder('a')
                            // pour les catégories, recherche texte sur le nom car plusieurs catégories ont le même nom et sont diférenciées par leur sous-catégorie (chmp 'nom2')
                            ->leftJoin('a.category', 'c');

            // $qb->setMaxResults(25);

            $qb->where('1 = 1');

            $data = array();

            /*
            à partir de _POST, on créé un tableau comme ceci :
            Array (
                [0] => Array
                        [field] => fiche
                        [value] => "AS329B2"

                [1] => Array
                        [field] => logic
                        [value] => "Ou"

                [2] => Array
                        [field] => categorie2
                        [value] => "lalala"

                [3] => Array
                        [field] => logic
                        [value] => "Et"

                [4] => Array
                        [field] => "monument"
                        [value] => "UNIVERSITÉ"
                ...
            */
                foreach($_POST as $field => $value) {
                    $field = substr($field, 0, strpos($field, '_'));
                    if(!empty($field) && !empty($value)) {
                        $data[] = array('field' => $field, 'value' => $value);
                    } elseif ('subcategories' == $field) {
                        $data[] = array('field' => 'subcategories', 'value' => '');
                    }
                }

#print_r('<pre>');
#print_r($data);
#print_r('</pre>');

            $value = array();

            /*
            1. Si c'est pas un champ de logique, on construit le SQL nécessaire
            2. On choisit la logique à appliquer
            */
            for($i = 0; $i < count($data); $i++) {

                $subcat = false;

                $field = $data[$i]['field'];
                if ('greektrans' == $field) {
                    $field = 'greek_trans';
                }
                $value[$i] = $data[$i]['value'];

#print_r('<br />field = '.$field);
#print_r(' - value = '.$value[$i]);

                switch($field) {
                    case 'logic':
                        continue;
                        break;
                    case 'category':
                        $op = '=';
                        break;
                    case 'category':
                        $op = '=';
                        break;
                    case 'subcategories':
                        $op = '=';
                        break;
                    case 'document':
                    case 'material':
                    case 'id':
                    case 'french':
                    case 'english':
                    case 'greek':
                    case 'greek_trans':
                        $op = '=';
                        break;
                    default:
                        $op = 'LIKE';
                        $value[$i] = '%'.$value[$i].'%';
                        break;
                }

                if($i === 0) {
                    $logic_to_apply = "And";
                } else {
                    $logic_to_apply = $data[$i-1]['value'];
                }

                if ( 'category' == $field ) {
                    $field = 'c.nom';
                    $last_logic = $logic_to_apply;
                    if (isset($data[$i+1]) && 'subcategories' == $data[$i+1]['field'] && '' != $data[$i+1]['value']) {
                        $subcat = true;
                    }
                } else {
                    $field = 'a.'.$field;
                }

                switch($logic_to_apply) {
                    case 'Or':
                        # cas "all fields"
                        if ($field == 'a.fiche') {
                            $qb->orWhere('a.nom LIKE :value'.$i.' OR a.french LIKE :value'.$i.' OR a.english LIKE :value'.$i.' OR a.greek LIKE :value'.$i.' OR a.greek_trans LIKE :value'.$i.' OR a.comments LIKE :value'.$i.' OR a.context LIKE :value'.$i)
                               ->setParameter('value'.$i, $value[$i]);
                            unset($value[$i]);
                        } else {
                            if ($subcat) {
                                $qb->orWhere($field.' '.$op.' :value'.$i.' AND c.nom2 '.$op. ' :value_subcat'.$i)
                                   ->setParameter('value'.$i, $value[$i])
                                   ->setParameter('value_subcat'.$i, $data[$i+1]['value']);
                            } else {
                                $qb->orWhere($field.' '.$op.' :value'.$i)
                                   ->setParameter('value'.$i, $value[$i]);
                            }
                        }
                        break;
                    case 'And':

                        # cas "all fields"
                        if ($field == 'a.fiche') {
                            $qb->andWhere('a.nom LIKE :value'.$i.' OR a.french LIKE :value'.$i.' OR a.english LIKE :value'.$i.' OR a.greek LIKE :value'.$i.' OR a.greek_trans LIKE :value'.$i.' OR a.comments LIKE :value'.$i.' OR a.context LIKE :value'.$i)
                               ->setParameter('value'.$i, $value[$i]);
                            unset($value[$i]);
                        } else {
                            if ($subcat) {
                                $qb->andWhere($field.' '.$op.' :value'.$i.' AND c.nom2 '.$op. ' :value_subcat'.$i)
                                   ->setParameter('value'.$i, $value[$i])
                                   ->setParameter('value_subcat'.$i, $data[$i+1]['value']);
                            } else {
                                $qb->andWhere($field.' '.$op.' :value'.$i)
                                   ->setParameter('value'.$i, $value[$i]);
                            }
                        }
                        break;
                    case 'And not':

                        if ($op === 'LIKE') {
                            $op = 'NOT '.$op;
                        } else {
                            $op = '!'.$op;
                        }
                        # cas "all fields"
                        if ($field == 'a.fiche') {
                            $qb->andWhere('a.nom NOT LIKE :value'.$i.' OR a.french NOT LIKE :value'.$i.' OR a.english NOT LIKE :value'.$i.' OR a.greek NOT LIKE :value'.$i.' OR a.greek_trans NOT LIKE :value'.$i.' OR a.comments NOT LIKE :value'.$i.' OR a.context NOT LIKE :value'.$i)
                               ->setParameter('value'.$i, $value[$i]);
                            unset($value[$i]);
                        } else {
                            if ($subcat) {
                                $qb->andWhere($field.' '.$op.' :value'.$i.' AND c.nom2 '.$op. ' :value_subcat'.$i)
                                   ->setParameter('value'.$i, $value[$i])
                                   ->setParameter('value_subcat'.$i, $data[$i+1]['value']);
                            } else {
                                 # ci-dessous, ajout du ' OR $field IS NULL' pour le problème des id_material* qui peuvent être NULL,
                                 # et dans ce cas là les enregistrements sont ignorés par MySQL, car pas de comparaison arithmétique avec NULL
                                $qb->andWhere($field.' '.$op.' :value'.$i.' OR '.$field.' IS NULL')
                                   ->setParameter('value'.$i, $value[$i]);
                            }
                        }
                        break;
                }
            }
            $qb->orderBy('a.greek', 'ASC');
            $qb->leftJoin('a.document', 'doc');
            $qb->addOrderBy('doc.nom', 'ASC');
            $qb->addOrderBy('a.reference', 'ASC');

            $all_serached_artefacts = $qb->select('a.id')->getQuery()->getArrayResult();
#            $ids = array();
#            foreach($all_serached_artefacts as $artefact) {
#                array_push($ids, $artefact->getId());
#            }
#            $ids = array_column($all_serached_artefacts, 'id');

            $ids = array_map('current', $all_serached_artefacts);
#print_r('ids: ');
#var_dump($ids);
#print_r('<hr />');
            $session->set('recherche_artefact_ids', $ids);

            $qb->select('a'); # pour avoir les objets, et pas seulement les id
            $qb->setFirstResult( ($page - 1) * 20 )
               ->setMaxResults( 20 );

            $query = $qb->getDql();
            $params = $qb->getParameters();
#print_r('<hr />'.$query.'<hr />'.var_dump($params));

            $artefacts = $qb->getQuery()->getResult();

            # pager
            $adapter  = new DoctrineORMAdapter($qb);
            $pager    = new PagerFanta($adapter);
            $pager->setMaxPerPage(20);
            try {
                $pager->setCurrentPage($page);
            } catch (NotValidCurrentPageException $e) {
                throw new NotFoundHttpException();
            }
        }

#        $session->set('request_artefact', $request);
        $session->set('request_artefact', $data);
        $session->set('last_request_type', 'artefact');

        # écraser les résultats des recherches précédentes
        $session->set('recherche_document_ids', array());
        $session->set('recherche_synthese_ids', array());
#        $session->set('request_document', null);
#        $session->set('request_synthese', null);
        # fin

        #***********************************************

        // cas de la sous-catégorie
        $subcategories = array();
        $count = 1;
        $skip = array();
        foreach ($data as $champ) {
            if ( $champ['field'] == 'category' ) {
                $subcategories[] = $em->getRepository('ApbTypikaBundle:Category')
                               ->createQueryBuilder('c')
                               ->select('DISTINCT(c.nom2) AS nom')
                               ->where('c.nom = :category')
                                    ->setParameter('category', $champ['value'])
                               ->orderBy('nom', 'ASC')
                               ->groupBy('nom')
                               ->getQuery()->getResult();
                $skip[$count] = $count;
            }
            $count++;
        }

#print_r('<pre>');
#print_r($subcategories);
#print_r('</pre>');

        return $this->render( 'ApbTypikaBundle:Default:recherche_artefact.html.twig', array(
            'titre' => 'Effectuer une recherche',
            'document'    => $document,
            'greek'       => $greek,
            'greek_trans' => $greek_trans,
            'french'      => $french,
            'english'     => $english,
            'categories'  => $categories,
            'subcategories'  => $subcategories,
            'materials'   => $materials,
            'request_data'=> $data,
            'artefacts'   => $artefacts,
            'page'        => $page,
            'pager'       => $pager,
            'ids'         => $ids,
            'skip'         => $skip
        ));
    }


    /**
     * @Route("/test")
     */
    public function testAction($page = 1, $all = false)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $query = $em->createQuery('SELECT c.id FROM ApbTypikaBundle:Category c');
        $ids = $query->getResult(); // array of CmsUser ids
        print_r( $ids );
        print_r( '<hr />' );
        print_r(count($ids));
        print_r( '<hr />' );
        print_r( array_map('current', $ids) );
        print_r( '<hr />' );
        print_r(count(array_map('current', $ids)));
}

    /**
     * @Route("/documentsearch/{page}/{all}")
     */
    public function documentSearchAction($page = 1, $all = false)
    {
        $session = $this->getRequest()->getSession();

        $data = $session->get('request_document');

        // On récupère le repository
        $repository = $this->getDoctrine()->getManager()->getRepository('ApbTypikaBundle:Document');

        $doc = new Document();
        $form_doc = $this->createForm(new SearchDocument(), $doc);

        $authorities = array();
        $authority = new Authority();
        $form_auth = $this->createForm(new SearchAuthority(), $doc);

        $request = $this->get('request');

        $documents = array();
        $pager = null;
        $ids = array();

        if( $all && 'POST' != $request->getMethod() ) {
            $session->set('request_document', null);
            $resultat = true;
            $query = $repository->createQueryBuilder( 'd' )
                                ->orderBy( 'd.nom', 'ASC' );

            # on récupère les id de tous les résultats
            $all_documents = $query->select('d.id')->getQuery()->getArrayResult();
            $ids = array_map('current', $all_documents);
#            $ids = array_column($all_documents, 'id');
            $query->select('d'); # ce select pour avoir toutes les infos des objets de la page courrante
#            $ids = array();
#            foreach($all_documents as $document) {
#                array_push($ids, $document->getId());
#            }

            $query->setFirstResult( ($page - 1) * 20 )
                  ->setMaxResults( 20 );
            $documents = $query->getQuery()->getResult();

            $session->set('recherche_document_ids', $ids);
            $session->set('request_documents', null);
            $data = array();

            # pager
            $adapter  = new DoctrineORMAdapter($query);
            $pager    = new PagerFanta($adapter);
            $pager->setMaxPerPage(20);
            try {
                $pager->setCurrentPage($page);
            } catch (NotValidCurrentPageException $e) {
                throw new NotFoundHttpException();
            }
        }

        if( !$all && $session->has('recherche_document_ids') && 'POST' != $request->getMethod() ) {
            $ids = $session->get('recherche_document_ids');
            $form_auth->bind($session->get('request_document'));

            $resultat = true;
            $query = $repository->createQueryBuilder( 'd' );

            if ( count($ids) > 0 ) {
                $query
                    ->where('d.id IN (:ids)')
                        ->setParameter( 'ids',$ids )
                    ->orderBy( 'd.nom', 'ASC' )
                    ->setFirstResult( ($page - 1) * 20 )
                    ->setMaxResults( 20 );
                $documents = $query->getQuery()->getResult();

                # pager
                $adapter  = new DoctrineORMAdapter($query);
                $pager    = new PagerFanta($adapter);
                $pager->setMaxPerPage(20);
                try {
                    $pager->setCurrentPage($page);
                } catch (NotValidCurrentPageException $e) {
                    throw new NotFoundHttpException();
                }
            }
        }

        if ('POST' == $request->getMethod()) {
            //le résultat posté doit être mappé sur l'entité sur lequel le formulaire est basé
            //de sorte que $data soit un Fiche
            $page = 1;

            if(!empty($_POST['searchdoc'])) {
                $form_doc->bind($request);
                $data = $form_doc->getData();
#                $qb = $repository->createQueryBuilder('d');
#                $qb->where('d.id = :doc')
#                    ->setParameter('doc', $data->getNom());

                $url = $this->generateUrl(
                    'apb_typika_default_document',
                    array('id' => $data->getNom()->getId())
                );
                return $this->redirect($url);
            } else {
                $form_auth->bind($request);
                $data = $form_auth->getData();
                $qb = $repository->createQueryBuilder('d');
                $qb->where('1 = 2');
                $qb->OrWhere('d.authority = :auth')
                   ->setParameter('auth', $data->getAuthority());
                $qb->OrWhere('d.type = :doctype')
                   ->setParameter('doctype', $data->getType());
                $qb->orderBy('d.nom', 'ASC');
            }

            $session->set('document_data', $data);

            $all_documents = $qb->select('d.id')->getQuery()->getArrayResult();
#            $ids = array_column($all_documents, 'id'); // array_column => PHP 5.5!!!
            $ids = array_map('current', $all_documents);
            $qb->select('d'); # pour avoir les objets, et pas seulement les id

            $session->set('recherche_document_ids', $ids);
            $session->set('request_document', $request);

            $qb->setFirstResult( ($page - 1) * 20 )
               ->setMaxResults( 20 );

            $documents = $qb->getQuery()->getResult();

            # pager
            $adapter  = new DoctrineORMAdapter($qb);
            $pager    = new PagerFanta($adapter);
            $pager->setMaxPerPage(20);
            try {
                $pager->setCurrentPage($page);
            } catch (NotValidCurrentPageException $e) {
                throw new NotFoundHttpException();
            }

#            return $this->render(
#                'ApbTypikaBundle:Default:result_documents.html.twig',
#                array(
#                    'titre' => 'Résultats de recherche',
#                    'documents' => $documents
#                    )
#            );
        }

        # écraser les résultats des recherches précédentes
        $session->set('recherche_artefact_ids', array());
        $session->set('recherche_synthese_ids', array());
#        $session->set('request_artefact', array());
#        $session->set('request_synthese', null);
        # fin

        $session->set('last_request_type', 'document');

        return $this->render(
            'ApbTypikaBundle:Default:recherche_document.html.twig',
            array(
                'titre'     => 'Effectuer une recherche',
                'form_doc'  => $form_doc->createView(),
                'form_auth' => $form_auth->createView(),
                'documents' => $documents,
                'page'      => $page,
                'pager'     => $pager,
                'ids'       => $ids,
                )
        );
    }

    /**
     * @Route("/synthesissearch/{all}")
     */
    public function synthesisSearchAction($all = false)
    {
        $session = $this->getRequest()->getSession();

        $documents = array();
        $doc = new Synthese();
        $form_synth = $this->createForm(new SearchSynthese(), $doc);

        $ids = array();
        $syntheses = array();

        $request = $this->get('request');

        if ( $all ) {
            $syntheses = $this->getDoctrine()->getManager()->getRepository('ApbTypikaBundle:Synthese')->findBy(array(), array('greek' => 'ASC'));

            return $this->render(
                'ApbTypikaBundle:Default:recherche_synthese.html.twig',
                array(
                    'titre' => 'Résultats de recherche',
                    'syntheses' => $syntheses,
                    'form_synth' => $form_synth->createView(),
                    )
            );
        }

        if( !$all && $session->has('recherche_synthese_ids') && 'POST' != $request->getMethod() ) {
            $ids = $session->get('recherche_synthese_ids');
            $form_synth->bind($session->get('request_synthese'));

            $resultat = true;
            $query = $this->getDoctrine()->getManager()->getRepository('ApbTypikaBundle:Synthese')->createQueryBuilder( 's' );

            if ( count($ids) > 0 ) {
                $query
                    ->where('s.id IN (:ids)')
                        ->setParameter( 'ids',$ids )
                    ->orderBy( 's.greek', 'ASC' );
                $syntheses = $query->getQuery()->getResult();
            }
        }

        if ('POST' == $request->getMethod()) {
            // On récupère le repository
            $repository = $this->getDoctrine()->getManager()->getRepository('ApbTypikaBundle:Synthese');

            if(!empty($_POST['searchdoc'])) {
                $form_synth->bind($request);
                $data = $form_synth->getData();
#                $qb = $repository->createQueryBuilder('s');
#                $qb->where('s.greek = :greek')
#                ->setParameter('greek', $data->getGreek()->getId());

                $url = $this->generateUrl(
                    'apb_typika_default_synthese',
                    array('id' => $data->getGreek()->getId())
                );
                return $this->redirect($url);

            } else {
                $form_synth->bind($request);
                $data = $form_synth->getData();

                $qb = $repository->createQueryBuilder('s');
                $qb->where('1 = 2');

                if ( $data->getDefinition() ) {
                    $definition = $data->getDefinition();
                    $qb->leftJoin('s.references', 'r');
                    $qb->OrWhere('s.french LIKE :definition OR s.greek LIKE :definition OR s.english LIKE :definition OR s.definition LIKE :definition OR r.text LIKE :definition')
                       ->setParameter('definition', '%'.$definition.'%')
                       ->add('groupBy', 's.id');
                }

                if ( $data->getFrench() ) {
                    $french = $repository->find( $data->getFrench() )->getFrench();
                    $qb->OrWhere('s.french = :french')
                       ->setParameter('french', $french);
                }

                if ( $data->getEnglish() ) {
                    $english = $repository->find( $data->getEnglish() )->getEnglish();
                    $qb->OrWhere('s.english = :english')
                       ->setParameter('english', $english);
                }
                $qb->orderBy('s.greek', 'ASC');
            }

            $all_syntheses = $qb->select('s.id')->getQuery()->getArrayResult();
            $ids = array_map('current', $all_syntheses);

            $qb->select('s'); # pour avoir les objets
            $query = $qb->getQuery();
            $syntheses = $query->getArrayResult();

#            foreach($syntheses as $synthese) {
#                array_push($ids, $synthese->getId());
#            }
            $session->set('recherche_synthese_ids', $ids);
            $session->set('request_synthese', $request);
        }

        $session->set('recherche_artefact_ids', array());
        $session->set('recherche_document_ids', array());
#        $session->set('request_artefact', array());
#        $session->set('request_document', null);

        $session->set('last_request_type', 'synthesis');

        return $this->render(
            'ApbTypikaBundle:Default:recherche_synthese.html.twig',
            array(
                'titre' => 'Search',
                'syntheses' => $syntheses,
                'form_synth' => $form_synth->createView(),
                'ids'   => $ids
                )
        );
    }

#    /**
#     * @Route("/artefactresult")
#     */
#    public function artefactResultAction()
#    {
#        $request = $this->get('request');

#        if( 'POST' == $request->getMethod() ) {
#            // On récupère le repository
#            $repository = $this->getDoctrine()->getManager()->getRepository( 'ApbTypikaBundle:Artefact' );

#            $qb = $repository->createQueryBuilder('a');

#            // $qb->setMaxResults(25);

#            $qb->where('1 = 1');

#            $data = array();

#            /*
#            à partir de _POST, on créé un tableau comme ceci :
#            Array (
#                [0] => Array
#                        [field] => fiche
#                        [value] => "AS329B2"

#                [1] => Array
#                        [field] => logic
#                        [value] => "Ou"

#                [2] => Array
#                        [field] => categorie2
#                        [value] => "lalala"

#                [3] => Array
#                        [field] => logic
#                        [value] => "Et"

#                [4] => Array
#                        [field] => "monument"
#                        [value] => "UNIVERSITÉ"
#                ...
#            */
#                foreach($_POST as $field => $value) {
#                    $field = substr($field, 0, strpos($field, '_'));
#                    if(!empty($field) && !empty($value)) {
#                        $data[] = array('field' => $field, 'value' => $value);
#                    }
#                }

#            $value = array();

#            /*
#            1. Si c'est pas un champ de logique, on construit le SQL nécessaire
#            2. On choisit la logique à appliquer
#            */
#            for($i = 0; $i < count($data); $i++) {
#                $field = $data[$i]['field'];
#                $value[$i] = $data[$i]['value'];

#                switch($field) {
#                    case 'logic':
#                        continue;
#                        break;
#                    case 'document':
#                    case 'category':
#                    case 'material':
#                    case 'id':
#                        $op = '=';
#                        break;
#                    default:
#                        $op = 'LIKE';
#                        $value[$i] = '%'.$value[$i].'%';
#                        break;
#                }

#                $field = 'a.'.$field;

#                if($i === 0) {
#                    $logic_to_apply = "And";
#                } else {
#                    $logic_to_apply = $data[$i-1]['value'];
#                }

#                switch($logic_to_apply) {
#                    case 'Or':
#                        # cas "all fields"
#                        if ($field == 'a.fiche') {
#                            $qb->orWhere('a.nom LIKE :value'.$i.' OR a.french LIKE :value'.$i.' OR a.english LIKE :value'.$i.' OR a.greek LIKE :value'.$i.' OR a.greek_trans LIKE :value'.$i.' OR a.comments LIKE :value'.$i.' OR a.context LIKE :value'.$i)
#                               ->setParameter('value'.$i, $value[$i]);
#                            unset($value[$i]);
#                        } else {
#                            $qb->orWhere($field.' '.$op.' :value'.$i)
#                               ->setParameter('value'.$i, $value[$i]);
#                        }
#                        break;
#                    case 'And':

#                        # cas "all fields"
#                        if ($field == 'a.fiche') {
#                            $qb->andWhere('a.nom LIKE :value'.$i.' OR a.french LIKE :value'.$i.' OR a.english LIKE :value'.$i.' OR a.greek LIKE :value'.$i.' OR a.greek_trans LIKE :value'.$i.' OR a.comments LIKE :value'.$i.' OR a.context LIKE :value'.$i)
#                               ->setParameter('value'.$i, $value[$i]);
#                            unset($value[$i]);
#                        } else {
#                            $qb->andWhere($field.' '.$op.' :value'.$i)
#                               ->setParameter('value'.$i, $value[$i]);
#                        }
#                        break;
#                    case 'And not':

#                        if ($op === 'LIKE') {
#                            $op = 'NOT '.$op;
#                        } else {
#                            $op = '!'.$op;
#                        }
#                        # cas "all fields"
#                        if ($field == 'a.fiche') {
#                            $qb->andWhere('a.nom NOT LIKE :value'.$i.' OR a.french NOT LIKE :value'.$i.' OR a.english NOT LIKE :value'.$i.' OR a.greek NOT LIKE :value'.$i.' OR a.greek_trans NOT LIKE :value'.$i.' OR a.comments NOT LIKE :value'.$i.' OR a.context NOT LIKE :value'.$i)
#                               ->setParameter('value'.$i, $value[$i]);
#                            unset($value[$i]);
#                        } else {
#                            $qb->andWhere($field.' '.$op.' :value'.$i)
#                               ->setParameter('value'.$i, $value[$i]);
#                        }
#                    break;
#                }
#            }
#            $qb->orderBy('a.greek', 'ASC');

#            $query = $qb->getDql();

#            $artefacts = $qb->getQuery()->getResult();

#            # pager
#            $adapter  = new DoctrineORMAdapter($query);
#            $pager    = new PagerFanta($adapter);
#            $pager->setMaxPerPage(20);
#            try {
#                $pager->setCurrentPage($page);
#            } catch (NotValidCurrentPageException $e) {
#                throw new NotFoundHttpException();
#            }
#        }

#        $session = $this->getRequest()->getSession();
#        $session->set('request_artefact', $data);
#        $session->set('last_request_type', 'artefact');

##        return $this->render( 'ApbTypikaBundle:Default:result_artefact.html.twig', array(
#        return $this->render( 'ApbTypikaBundle:Default:result_artefact.html.twig', array(
#            'titre' => 'Résultats de recherche',
#            'artefacts' => $artefacts,
#            'data'  => $data,
#            'page'      => $page,
#            'pager'     => $pager
#            ));
#    }

    /**
     * @Route("/allartefacts/{page}")
     * @Template()
     */
    public function allartefactsAction($page = 1)
    {
#        $artefacts = $this->getDoctrine()->getManager()->getRepository('ApbTypikaBundle:Artefact')->findBy(array(), array('greek' => 'ASC'));
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('ApbTypikaBundle:Artefact')
                        ->createQueryBuilder('a')
                        ->orderBy("a.greek", 'ASC')
                        ->setFirstResult( ($page - 1) * 20 )
                        ->setMaxResults( 20 )
                    ->getQuery();
        $artefacts = $query->getResult();

        # pager
        $adapter  = new DoctrineORMAdapter($query);
        $pager    = new PagerFanta($adapter);
        $pager->setMaxPerPage(20);
        try {
            $pager->setCurrentPage($page);
        } catch (NotValidCurrentPageException $e) {
            throw new NotFoundHttpException();
        }


        return $this->render(
            'ApbTypikaBundle:Default:result_artefact.html.twig',
            array(
                'titre'     => 'All artefacts',
                'artefacts' => $artefacts,
                'page'      => $page,
                'pager'     => $pager
                )
        );
    }

    /**
     * @Route("/alldocuments/{page}")
     * @Template()
     */
    public function alldocumentsAction($page = 1)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('ApbTypikaBundle:Document')
                        ->createQueryBuilder('d')
#                        ->orderBy("d.greek", 'ASC')
                        ->setFirstResult( ($page - 1) * 20 )
                        ->setMaxResults( 20 )
                    ->getQuery();
        $documents = $query->getResult();

        # pager
        $adapter  = new DoctrineORMAdapter($query);
        $pager    = new PagerFanta($adapter);
        $pager->setMaxPerPage(20);
        try {
            $pager->setCurrentPage($page);
        } catch (NotValidCurrentPageException $e) {
            throw new NotFoundHttpException();
        }


        return $this->render(
            'ApbTypikaBundle:Default:result_documents.html.twig',
            array(
                'titre'     => 'All documents',
                'documents' => $documents,
                'page'      => $page,
                'pager'     => $pager
                )
        );
    }

    /**
     * @Route("/allsynthesis")
     * @Template()
     */
    public function allsynthesisAction()
    {
        $syntheses = $this->getDoctrine()->getManager()->getRepository('ApbTypikaBundle:Synthese')->findBy(array(), array('greek' => 'ASC'));

        return $this->render(
            'ApbTypikaBundle:Default:result_syntheses.html.twig',
            array(
                'titre' => 'Résultats de recherche',
                'syntheses' => $syntheses
                )
        );
    }

    /**
     * @Route("/artefact/{id}")
     * @Template()
     */
    public function artefactAction(Artefact $artefact)
    {
        $session = $this->getRequest()->getSession();
        $prev = false;
        $next = false;
        $ids = $session->get('recherche_artefact_ids');
        if ( $ids ) {
            $index = array_search($artefact->getId(), $ids);
            $prev = $index > 0 ? $ids[$index - 1] : false;
            $next = $index < count($ids)-1 ? $ids[$index + 1] : false;
        }
        return array(
            'titre'     => $artefact->getGreek(),
            'artefact'  => $artefact,
            'prev'      => $prev,
            'next'      => $next
        );
    }

    /**
     * @Route("/synthese/{id}/{relatedartefact}", defaults={"relatedartefact"=false})
     * @Template()
     */
    public function syntheseAction(Synthese $synthese, $relatedartefact)
    {
        $session = $this->getRequest()->getSession();
#        $session->set('last_request_type', 'synthesis');

        $index = false;
        $prev = false;
        $next = false;

        $ids = $session->get('recherche_synthese_ids');
        if ( $ids ) {
            $index = array_search($synthese->getId(), $ids);
            $prev = $index > 0 ? $ids[$index - 1] : false;
            $next = $index < count($ids)-1 ? $ids[$index + 1] : false;
        }

        $artefacts = array();

        if ($relatedartefact) {
            $repository = $this->getDoctrine()->getManager()->getRepository( 'ApbTypikaBundle:Artefact' );
            $qb = $repository->createQueryBuilder('a')
                             ->where('a.synthese = :id')
                             ->setParameter('id', $synthese->getId())
                             ->orderBy('a.greek', 'ASC');

            $query = $qb->getDql();

            $artefacts = $qb->getQuery()->getResult();

            # écraser les résultats des recherches précédentes
            $all_serached_artefacts = $qb->select('a.id')->getQuery()->getArrayResult();
            $ids = array_map('current', $all_serached_artefacts);
            $session->set('recherche_artefact_ids', $ids);
            $session->set('last_request_type', 'artefact');
            $session->set('request_artefact', array());
            # fin
        }

        return array(
            'titre' => $synthese->getGreek(),
            'synthese' => $synthese,
            'artefacts' => $artefacts,
            'prev'      => $prev,
            'next'      => $next
        );
    }

    /**
     * @Route("/document/{id}/{relatedartefact}", defaults={"relatedartefact"=false})
     * @Template()
     */
    public function documentAction(Document $document, $relatedartefact)
    {
        $session = $this->getRequest()->getSession();
#        $session->set('last_request_type', 'document');

        $index = false;
        $prev = false;
        $next = false;

        $ids = $session->get('recherche_document_ids');
        if ( $ids ) {
            $index = array_search($document->getId(), $ids);
            $prev = $index > 0 ? $ids[$index - 1] : false;
            $next = $index < count($ids)-1 ? $ids[$index + 1] : false;
        }

        $artefacts = array();

        if ($relatedartefact) {
            $repository = $this->getDoctrine()->getManager()->getRepository( 'ApbTypikaBundle:Artefact' );
            $qb = $repository->createQueryBuilder('a')
                             ->where('a.document = :id')
                             ->setParameter('id', $document->getId())
                             ->orderBy('a.greek', 'ASC');

            $query = $qb->getDql();

            $artefacts = $qb->getQuery()->getResult();

            # écraser les résultats des recherches précédentes
            $all_serached_artefacts = $qb->select('a.id')->getQuery()->getArrayResult();
            $ids = array_map('current', $all_serached_artefacts);
            $session->set('recherche_artefact_ids', $ids);
            $session->set('last_request_type', 'artefact');
            $session->set('request_artefact', array());
            # fin
        }

        return array(
            'titre' => $document->getNom(),
            'document' => $document,
            'artefacts' => $artefacts,
            'prev'      => $prev,
            'next'      => $next
        );
    }

    /**
     * @Route("/contact")
     * @Template()
     */
    public function contactAction()
    {
        return array(
            'titre' => 'Contact',
        );
    }

    /**
     * @Route("/faq")
     * @Template()
     */
    public function faqAction()
    {
        $em = $this->getDoctrine()->getManager();

        $faqs = $em->getRepository('ApbTypikaBundle:Faq')->findBy(array(), array('title' => 'ASC'));
        return array(
            'titre' => 'FAQ',
            'faqs'  => $faqs
        );
    }

    /**
     * @Route("/relatedArtefact/{type}/{id}")
     * @Template()
     */
    public function relatedArtefactAction($type, $id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository( 'ApbTypikaBundle:Artefact' );
        $qb = $repository->createQueryBuilder('a')
                         ->orderBy('a.greek', 'ASC');
        switch($type){
            case 'document':
                $qb->where('a.document = :id')
                   ->setParameter('id', $id);
                break;
            default:
                $qb->where('a.synthese = :id')
                   ->setParameter('id', $id);
                break;
        }

        $query = $qb->getDql();

        $artefacts = $qb->getQuery()->getResult();

        return $this->render( 'ApbTypikaBundle:Default:result_artefact.html.twig', array(
            'titre' => 'Résultats de recherche',
            'artefacts' => $artefacts,
            ));
    }

    /**
     * @Route("/bibliographies")
     * @Template()
     */
    public function bibliographiesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $bibliographies = $em->getRepository('ApbTypikaBundle:Bibliography')->findBy(array(), array('entry' => 'ASC'));
        $sources = $em->getRepository('ApbTypikaBundle:Sources')->findBy(array(), array('entry' => 'ASC'));

        return array(
            'titre' => 'Bibliography',
            'bibliographies'  => $bibliographies,
            'sources'  => $sources,
        );
    }

    /**
     * @Route("/sources")
     * @Template()
     */
    public function sourcesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sources = $em->getRepository('ApbTypikaBundle:Sources')->findBy(array(), array('entry' => 'ASC'));
        return array(
            'titre' => 'Sources',
            'sources'  => $sources
        );
    }


    /**
     * @Route("/subcategories")
     * @Template()
     */
    public function subcategoriesAction()
    {
        $request = $this->getRequest();
        if($request->isXmlHttpRequest())
        {
            $nom = $request->get('nom');
            if ($nom)
            {
                $em = $this->getDoctrine()->getManager();
                $subcategories = $em->getRepository('ApbTypikaBundle:Category')->findBy(array('nom' => $nom), array('nom2' => 'ASC'));
                $result = array();
                $i = 0;
                foreach($subcategories as $subcategory) // pour transformer la réponse à ta requete en tableau qui replira le select2
                {
                    $result[]['nom'] = $subcategory->getNom2();
                    $i++;
                }
                $response = new Response();
                $data = json_encode($result); // c'est pour formater la réponse de la requete en format que jquery va comprendre
                $response->headers->set('Content-Type', 'application/json');
                $response->setContent($data);
                return $response;
            }
        }
        return new Response('Erreur');
    }

}
