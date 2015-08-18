<?php

namespace Apb\DiathequeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Apb\DiathequeBundle\Entity\Dia;
use Apb\DiathequeBundle\Form\SearchDia;
use Apb\DiathequeBundle\Form\AdvancedSearchDia;

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
        $page = $em->getRepository('ApbDiathequeBundle:Pages')->find($id);
        return array('page' => $page);
    }

    /**
     * @Route("/fiche/{id}/{print}")
     * @Template()
     */
    public function ficheAction(Dia $dia, $print = false)
    {
        return array(
            'titre' => $dia->getFiche(),
            'dia' => $dia,
            'print' => $print
        );
    }


    /**
     * @Route("/recherche")
     */
    public function searchAction()
    {
        $session = $this->getRequest()->getSession();
        $object = $session->get('recherche_diatheque_last_request') ? $session->get('recherche_diatheque_last_request') : 'standard';
        $url = $this->generateUrl(
            'apb_diatheque_default_' . $object . 'search'
        );
        return $this->redirect($url);
    }

    /**
     * @Route("/recherchestandard/{page}/{print}", defaults={"page" = 1, "print" = 0})
     */
    public function standardSearchAction($page, $print)
    {
        $dia = new Dia();
        $dias = array();
        $session = $this->getRequest()->getSession();
        $max_page = 10; # nb de résultats par page
        if ($session->has('request_diatheque_data')) {
            $data = $session->get('request_diatheque_data');
        } else {
            $data = array();
        }
        $logic = $session->get('dia_search_logic');

        $form = $this->createForm(new SearchDia(), $dia);

        $request = $this->get('request');
        if ($print) {
            $request = $session->get('dia_search_request');
        }
        
        if ($session->has('dia_search_request') && 'POST' != $request->getMethod()) {
            $form->bind($session->get('dia_search_request'));
        }

        // On récupère le repository
        $repository = $this->getDoctrine()->getManager()->getRepository('ApbDiathequeBundle:Dia');

        if ( 'POST' == $request->getMethod() && !$print) {
            $page = 1;
            $session->set('dia_search_request', $request);

            //le résultat posté doit être mappé sur l'entité sur lequel le formulaire est basé
            $form->bind($request);

            //de sorte que $data soit un Fiche
            $data = $form->getData();

            $qb = $repository->createQueryBuilder('d');

            $logic = isset($_POST['comb']) ? $_POST['comb'] : $session->get('dia_search_logic');
            $session->set('dia_search_logic', $logic);
            $session->set('request_diatheque_data', $data);

            if ($logic === 'et') {
                $first_cond = true;

                if ($data->getFiche() != '') {
                    if ($first_cond) {
                        $qb->where('1 = 1');
                        $first_cond = false;
                    }
                    $qb->andWhere('d.fiche LIKE :fiche')
                            ->setParameter('fiche', '%'.$data->getFiche().'%');
                }
                if ($data->getMonument() != '') {
                    if ($first_cond) {
                        $qb->where('1 = 1');
                        $first_cond = false;
                    }
                    $qb->andWhere('d.monument LIKE :monument')
                            ->setParameter('monument', '%'.$data->getMonument().'%');
                }
                if ($data->getDescription() != '') {
                    if ($first_cond) {
                        $qb->where('1 = 1');
                        $first_cond = false;
                    }
                    $qb->andWhere('d.description LIKE :description')
                            ->setParameter('description', '%'.$data->getDescription().'%');
                }
                if ($data->getReference() != '') {
                    if ($first_cond) {
                        $qb->where('1 = 1');
                        $first_cond = false;
                    }
                    $qb->andWhere('d.reference LIKE :reference')
                            ->setParameter('reference', '%'.$data->getReference().'%');
                }
                if ($data->getCategorie1() != '') {
                    if ($first_cond) {
                        $qb->where('1 = 1');
                        $first_cond = false;
                    }
                    $qb->andWhere('d.categorie1 = :cat1')
                            ->setParameter('cat1', $data->getCategorie1());
                }
                if ($data->getCategorie2() != '') {
                    if ($first_cond) {
                        $qb->where('1 = 1');
                        $first_cond = false;
                    }
                    $qb->andWhere('d.categorie2 = :cat2')
                            ->setParameter('cat2', $data->getCategorie2());
                }
                if ($data->getNbCouleur() != '') {
                    if ($first_cond) {
                        $qb->where('1 = 1');
                        $first_cond = false;
                    }
                    $qb->andWhere('d.nbCouleur = :nbc')
                            ->setParameter('nbc', $data->getNbCouleur());
                }
                if (count($qb->getQuery()->getParameters()) === 0) {
                    $qb->andWhere('1 = 2');
                }

            } else {
                $qb->where('1 = 2');

                if ($data->getFiche() != '') {
                    $qb->orWhere('d.fiche LIKE :fiche')
                        ->setParameter('fiche', '%'.$data->getFiche().'%');
                }
                if ($data->getMonument() != '') {
                    $qb->orWhere('d.monument LIKE :monument')
                        ->setParameter('monument', '%'.$data->getMonument().'%');
                }
                if ($data->getDescription() != '') {
                    $qb->orWhere('d.description LIKE :description')
                        ->setParameter('description', '%'.$data->getDescription().'%');
                }
                if ($data->getReference() != '') {
                    $qb->orWhere('d.reference LIKE :reference')
                        ->setParameter('reference', '%'.$data->getReference().'%');
                }
                if ($data->getCategorie1() != '') {
                    $qb->orWhere('d.categorie1 = :cat1')
                        ->setParameter('cat1', $data->getCategorie1());
                }
                if ($data->getCategorie2() != '') {
                    $qb->orWhere('d.categorie2 = :cat2')
                        ->setParameter('cat2', $data->getCategorie2());
                }
                if ($data->getNbCouleur() != '') {
                    $qb->orWhere('d.nbCouleur = :nbc')
                        ->setParameter('nbc', $data->getNbCouleur());
                }
            }
#            $dql = $qb->getDql();
#            print_r("<br>".$dql);

            $all_dias = $qb->select('d.id')->getQuery()->getArrayResult();

            $ids = array();
#            foreach($all_dias as $dia) {
#                array_push($ids, $dia->getId());
#            }
#            $qb2 = $qb;
#            $ids2 = $qb2->select('d.id')->getQuery()->getResult();
#            $ids = array_column($all_dias, 'id');
            $ids = array_map('current', $all_dias);
            $qb->select('d'); # pour avoir les objets, et pas seulement les id
#print_r(var_dump($ids));
#print_r("<hr/>");
#print_r(var_dump($all_dias));
            $session->set('recherche_diatheque_ids', $ids);
            $session->set('recherche_diatheque_last_request', 'standard');

            $qb->setFirstResult( ($page - 1) * $max_page )
                  ->setMaxResults( $max_page );
            $query = $qb->getQuery();
            $dias = $query->getResult();

            # pager
            $adapter  = new DoctrineORMAdapter($qb);
            $pager    = new PagerFanta($adapter);
            $pager->setMaxPerPage($max_page);
            try {
                $pager->setCurrentPage($page);
            } catch (NotValidCurrentPageException $e) {
                throw new NotFoundHttpException();
            }

            return $this->render('ApbDiathequeBundle:Default:search.html.twig', array(
                'titre' => 'Résultats de recherche',
                'form'  => $form->createView(),
                'dias'  => $dias,
                'ids'   => $ids,
                'print' => $print,
                'page'  => $page,
                'pager' => $pager,
                'logic' => $logic,
                ));
        }

#        // print
#        if ($session->has('dia_search_request')) {
#            $query = $session->get('dia_search_request');
#        }

        if( $session->has('recherche_diatheque_ids') && ('POST' != $request->getMethod() || $print ) ) {
            $ids = $session->get('recherche_diatheque_ids');
            $resultat = true;
            $pager = null;
            $query = $repository->createQueryBuilder( 'd' );

            if ( count($ids) > 0 ) {
                $query
                    ->where('d.id IN (:ids)')
                        ->setParameter( 'ids',$ids )
                    ->orderBy( 'd.fiche', 'ASC' )
                    ->setFirstResult( ($page - 1) * $max_page )
                    ->setMaxResults( $max_page );
                $dias = $query->getQuery()->getResult();

                # pager
                $adapter  = new DoctrineORMAdapter($query);
                $pager    = new PagerFanta($adapter);
                $pager->setMaxPerPage($max_page);
                try {
                    $pager->setCurrentPage($page);
                } catch (NotValidCurrentPageException $e) {
                    throw new NotFoundHttpException();
                }
            }

            if ($print){
                $template = 'ApbDiathequeBundle:Default:searchprint.html.twig';
            } else {
                $template = 'ApbDiathequeBundle:Default:search.html.twig';
            }

            return $this->render($template, array(
                'titre' => 'Résultats de recherche',
                'form'  => $form->createView(),
                'dias'  => $dias,
                'ids'   => $ids,
                'print' => $print,
                'page'  => $page,
                'pager' => $pager,
                'logic' => $logic,
                ));
        }

        return $this->render('ApbDiathequeBundle:Default:search.html.twig', array(
            'titre' => 'Effectuer une recherche',
            'form'  => $form->createView(),
            'print' => $print,
            'page'  => $page,
            ));
    }


    /**
     * @Route("/rechercheavancee/{page}/{print}", defaults={"page" = 1, "print" = 0})
     */
    public function advancedSearchAction( $page, $print )
    {
        $template = 'ApbDiathequeBundle:Default:advancedsearch.html.twig';

        $dia = new Dia();
        $dias = null;
        $ids = null;
        $pager = null;

        $form = $this->createForm(new AdvancedSearchDia(), $dia);

        $categories = $this->getDoctrine()
        ->getManager()
        ->getRepository('ApbDiathequeBundle:Categorie')
        ->findBy(array(), array('categorie' => 'asc'));

        $nbcouleurs = $this->getDoctrine()
        ->getManager()
        ->getRepository('ApbDiathequeBundle:Nbcouleur')
        ->findBy(array(), array('nbcouleur' => 'asc'));

        $session = $this->getRequest()->getSession();
        $session->has('recherche_diatheque_advanced_data') ? $data = $session->get('recherche_diatheque_advanced_data') : $data = array();
        $max_page = 20; # nb de résultats par page

        $request = $this->get('request');

        // On récupère le repository
        $repository = $this->getDoctrine()->getManager()->getRepository( 'ApbDiathequeBundle:Dia' );

        if( 'POST' == $request->getMethod() ) {

            $qb = $repository->createQueryBuilder('d');

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
                    if(!empty($field)) {
                        $data[] = array('field' => $field, 'value' => $value);
                    }
                }

#echo "<pre>";
#echo var_dump($_POST);
#echo "</pre>";

#echo "<pre>";
#echo var_dump($data);
#echo "</pre>";

            $session->set('recherche_diatheque_advanced_data', $data);
            $session->set('recherche_diatheque_last_request', 'advanced');

            $value = array();

            /*
            1. Si c'est pas un champ de logique, on construit le SQL nécessaire
            2. On choisit la logique à appliquer
            */
            for($i = 0; $i < count($data); $i++) {
                $field = $data[$i]['field'];
                $value[$i] = $data[$i]['value'];

                switch($field) {
                    case 'logic':
                    continue;
                    break;
                    case 'categorie1':
                    case 'categorie2':
                    case 'nbCouleur':
                    $op = '=';
                    break;
                    default:
                    $op = 'LIKE';
                    $value[$i] = '%'.$value[$i].'%';
                    break;
                }

                $field = 'd.'.$field;

                if($i === 0) {
                    $logic_to_apply = "Et";
                } else {
                    $logic_to_apply = $data[$i-1]['value'];
                }
                switch($logic_to_apply) {
                    case 'Ou':
                    $qb->orWhere($field.' '.$op.' :value_'.$i)
                    ->setParameter('value_'.$i, $value[$i]);
                    break;
                    case 'Et':
                    $qb->andWhere($field.' '.$op.' :value_'.$i)
                    ->setParameter('value_'.$i, $value[$i]);
                    break;
                    case 'Sauf':
                        if ($op === 'LIKE') {
                            $op = 'NOT '.$op;
                        } else {
                            $op = '!'.$op;
                        }
                    $qb->andWhere($field.' '.$op.' :value_'.$i)
                    ->setParameter('value_'.$i, $value[$i]);
                    break;
                }
            }


            $all_dias = $qb->select('d.id')->getQuery()->getArrayResult();
#            $ids = array_column($all_dias, 'id');
            $ids = array_map('current', $all_dias);
            $qb->select('d'); # pour avoir les objets, et pas seulement les id

            $session->set('recherche_diatheque_advanced_ids', $ids);

            $qb->setFirstResult( ($page - 1) * $max_page )
                  ->setMaxResults( $max_page );
            $query = $qb->getQuery();
            $dias = $query->getResult();

            # pager
            $adapter  = new DoctrineORMAdapter($qb);
            $pager    = new PagerFanta($adapter);
            $pager->setMaxPerPage($max_page);
            try {
                $pager->setCurrentPage($page);
            } catch (NotValidCurrentPageException $e) {
                throw new NotFoundHttpException();
            }

            $dias = $qb->getQuery()->getResult();
        }

        if( $session->has('recherche_diatheque_advanced_ids') && ('POST' != $request->getMethod() || $print) ) {
            $ids = $session->get('recherche_diatheque_advanced_ids'); 
            $resultat = true;
            $query = $repository->createQueryBuilder( 'd' );

            if ( count($ids) > 0 ) {
                $query
                    ->where('d.id IN (:ids)')
                        ->setParameter( 'ids',$ids )
                    ->orderBy( 'd.fiche', 'ASC' )
                    ->setFirstResult( ($page - 1) * $max_page )
                    ->setMaxResults( $max_page );
                $dias = $query->getQuery()->getResult();

                # pager
                $adapter  = new DoctrineORMAdapter($query);
                $pager    = new PagerFanta($adapter);
                $pager->setMaxPerPage($max_page);
                try {
                    $pager->setCurrentPage($page);
                } catch (NotValidCurrentPageException $e) {
                    throw new NotFoundHttpException();
                }
            }

            if ($print){
                $template = 'ApbDiathequeBundle:Default:searchprint.html.twig';
            }
        }

        return $this->render($template, array(
            'titre' => 'Effectuer une recherche',
            'categories' => $categories,
            'nbcouleurs' => $nbcouleurs,
            'dias'  => $dias,
            'ids'   => $ids,
            'print' => $print,
            'page'  => $page,
            'pager' => $pager,
            'data'  => $data,
            ));
    }

#    /**
#     * @Route("/rechercheavancee/resultat/{page}/{print}", defaults={"page" = 1, "print" = 0})
#     */
#    public function advancedSearchResultAction( $page, $print )
#    {
#        $dia = new Dia();

#        $form = $this->createForm(new AdvancedSearchDia(), $dia);

#        $categories = $this->getDoctrine()
#        ->getManager()
#        ->getRepository('ApbDiathequeBundle:Categorie')
#        ->findBy(array(), array('categorie' => 'asc'));

#        $nbcouleurs = $this->getDoctrine()
#        ->getManager()
#        ->getRepository('ApbDiathequeBundle:Nbcouleur')
#        ->findBy(array(), array('nbcouleur' => 'asc'));

#        $session = $this->getRequest()->getSession();
#        $max_page = 20; # nb de résultats par page

#        $request = $this->get('request');

#        // On récupère le repository
#        $repository = $this->getDoctrine()->getManager()->getRepository( 'ApbDiathequeBundle:Dia' );

#        if( 'POST' == $request->getMethod() ) {

#            $qb = $repository->createQueryBuilder('d');

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
#                    $field = substr($field, 0, strpos($field, '_cat'));
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
#                    continue;
#                    break;
#                    case 'categorie1':
#                    case 'categorie2':
#                    case 'nbCouleur':
#                    $op = '=';
#                    break;
#                    default:
#                    $op = 'LIKE';
#                    $value[$i] = '%'.$value[$i].'%';
#                    break;
#                }

#                $field = 'd.'.$field;

#                if($i === 0) {
#                    $logic_to_apply = "Et";
#                } else {
#                    $logic_to_apply = $data[$i-1]['value'];
#                }
#                switch($logic_to_apply) {
#                    case 'Ou':
#                    $qb->orWhere($field.' '.$op.' :value')
#                    ->setParameter('value', $value[$i]);
#                    break;
#                    case 'Et':
#                    $qb->andWhere($field.' '.$op.' :value')
#                    ->setParameter('value', $value[$i]);
#                    break;
#                    case 'Sauf':
#                        if ($op === 'LIKE') {
#                            $op = 'NOT '.$op;
#                        } else {
#                            $op = '!'.$op;
#                        }
#                    $qb->andWhere($field.' '.$op.' :value')
#                    ->setParameter('value', $value[$i]);
#                    break;
#                }
#            }

#            $query = $qb->getQuery();
#            $all_dias = $query->getResult();

#            $ids = array();
#            foreach($all_dias as $dia) {
#                array_push($ids, $dia->getId());
#            }
#            $session->set('recherche_diatheque_advanced_ids', $ids);

#            $qb->setFirstResult( ($page - 1) * $max_page )
#                  ->setMaxResults( $max_page );
#            $query = $qb->getQuery();
#            $dias = $query->getResult();

#            # pager
#            $adapter  = new DoctrineORMAdapter($qb);
#            $pager    = new PagerFanta($adapter);
#            $pager->setMaxPerPage($max_page);
#            try {
#                $pager->setCurrentPage($page);
#            } catch (NotValidCurrentPageException $e) {
#                throw new NotFoundHttpException();
#            }

#            $dias = $qb->getQuery()->getResult();
#        }

#        if( $session->has('recherche_diatheque_advanced_ids') && 'POST' != $request->getMethod() ) {
#            $ids = $session->get('recherche_diatheque_advanced_ids'); 
#            $resultat = true;
#            $query = $repository->createQueryBuilder( 'd' );

#            if ( count($ids) > 0 ) {
#                $query
#                    ->where('d.id IN (:ids)')
#                        ->setParameter( 'ids',$ids )
#                    ->orderBy( 'd.fiche', 'ASC' )
#                    ->setFirstResult( ($page - 1) * $max_page )
#                    ->setMaxResults( $max_page );
#                $dias = $query->getQuery()->getResult();

#                # pager
#                $adapter  = new DoctrineORMAdapter($query);
#                $pager    = new PagerFanta($adapter);
#                $pager->setMaxPerPage($max_page);
#                try {
#                    $pager->setCurrentPage($page);
#                } catch (NotValidCurrentPageException $e) {
#                    throw new NotFoundHttpException();
#                }
#            }
#        }

#        return $this->render( 'ApbDiathequeBundle:Default:advancedsearch.html.twig', array(
#            'titre' => 'Résultats de recherche',
#            'dias'  => $dias,
#            'ids'   => $ids,
#            'print' => $print,
#            'page'  => $page,
#            'pager' => $pager,
#            'categories' => $categories,
#            'nbcouleurs' => $nbcouleurs,
#            ));
#    }

    /**
     * @Route("/_migrate_images")
     * @Template()
     */
    public function migrateImagesAction()
    {
        // return $this->render( 'ApbDiathequeBundle:Default:migrate.html.twig', array(
        //     'debug' => $this->scandirrecursive('/srv/http/apb/web'),
        //     ));
        # à commenter pour exécuter la migration.
        return new Response('<html><body><h1>NOP!</h1></body></html>');
        exit();

        // paramètre à changer à "true" pour rendre les données persistantes dans la BD
        // par défaut : $PERSIST = false;
#		$PERSIST = false;
		$PERSIST = true;

		ini_set('max_execution_time', "3600"); // (1 hour) This script can take very long to execute!!!
		ini_set('memory_limit','8192M'); // And could also need a lot of memory!!!

        $em = $this->getDoctrine()->getManager();

        $dias = $em->getRepository('ApbDiathequeBundle:Dia')->findAll();
        
        // il faut parcourir l'ancienne table monuments et en extraire les catégories, 
        // chapitre, iconographie, images, lien, monuments, pays et section.
        // remplir la nouvelle table et lié le monument à l'enregistrement correspondant.
        foreach ($dias as $dia) {
            // On récupère le repository
            $repository = $this->getDoctrine()->getManager()->getRepository('Application\Sonata\MediaBundle\Entity\Media');
            $qb = $repository->createQueryBuilder('m');
            $qb->where("m.name LIKE :name AND m.context = 'diatheque'")
            ->setParameter('name', $dia->getFiche().'\_%');
            $query = $qb->getQuery();
            $medias = $query->getResult();
            
            $media = $medias != null ? $medias[0] : null;
            
            if ($media) {
                $dia->setImage($media);
                
                if ($PERSIST) {
                    $em->persist($dia);
#                    $em->flush();
                }
            }

#print_r("<hr>");
#print_r($monument);

        }
        $em->flush();

        return new Response('<html><body><h1>Conversion terminée!</h1></body></html>');
    }

    /**
     * @Route("/contact")
     * @Template()
     */
    public function contactAction()
    {
        $em = $this->getDoctrine()->getManager();
        $page = $em->getRepository('ApbDiathequeBundle:Pages')->find(2);

        return $this->render( 'ApbDiathequeBundle:Default:index.html.twig', array(
            'page' => $page,
            ));
    }
}
