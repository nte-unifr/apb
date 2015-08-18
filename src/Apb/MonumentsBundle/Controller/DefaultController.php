<?php

namespace Apb\MonumentsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;

use Apb\MonumentsBundle\Entity\Monument;
use Apb\MonumentsBundle\Entity\MonumentImages;

use Apb\MonumentsBundle\Form\SearchMonuments;

class DefaultController extends Controller
{
    /**
     * @Route("/page/{id}", defaults={"id" = 1})
     * @Route("/", defaults={"id" = 1})
     * @Template()
     */
    public function indexAction($id)
    {
        // $em = $this->getDoctrine()->getManager();
        // $r = $em->getRepository('ApplicationSonataMediaBundle:Media');

        // $monuments = $em->getRepository('ApbMonumentsBundle:Monument')->findAll();

        // $result = array();

        // foreach ($monuments as $m) {
        //     $id = $m->getId();
        //     $qb = $r->createQueryBuilder('d');
        //     $qb->andWhere('d.name LIKE :name')
        //        ->setParameter('name', $id.'-%.%');
        //     $medias = $qb->getQuery()->getResult();
        //     $chaine = '';
        //     foreach ($medias as $md) {
        //         $n = new MonumentImages();
        //         $n->setFiche($m);
        //         $n->setMedia($md);
        //         $em->persist($n);
        //     }
        // }
        // $em->flush();
        // $em->clear();

        $em = $this->getDoctrine()->getManager();

        $page = $em->getRepository('ApbMonumentsBundle:Pages')->find($id);
        return array('page' => $page);
    }

    /**
     * @Route("/recherche/{res}", defaults={"res" = 0})
     */
    public function searchAction($res)
    {
        $monument = new Monument();
        $monuments = array();
        $session = $this->getRequest()->getSession();

        $form = $this->createForm(new SearchMonuments(), $monument);
        $request = $this->get('request');

        if ($res) {
            $request = $session->get('monument_search_request');
        }

        $session->set('monument_search_request', $request);

#        if ($session->has('monument_search_request') && 'POST' != $request->getMethod()) {
#            $form->bind($session->get('monument_search_request'));
#        }

        if ('POST' == $request->getMethod() || ($session->has('monument_search_request') && $res)) {

            // On récupère le repository
            $repository = $this->getDoctrine()->getManager()->getRepository('ApbMonumentsBundle:Monument');

            //le résultat posté doit être mappé sur l'entité sur lequel le formulaire est basé
            $form->bind($request);

            //de sorte que $data soit un Fiche
            $data = $form->getData();

            $qb = $repository->createQueryBuilder('d');

            $qb->setMaxResults(25);

#            $logic = $_POST['comb'];
            $logic = isset($_POST['comb']) ? $_POST['comb'] : $session->get('dia_search_logic');
            $session->set('monument_search_logic', $logic);

            if ($logic === 'et') {
                $first_cond = true;

                if ($data->getSection() != '') {
                    if ($first_cond) {
                        $qb->where('1 = 1');
                        $first_cond = false;
                    }
                    $qb->andWhere('d.section = :section')
                    ->setParameter('section', $data->getSection());
                }
                if ($data->getChapitre() != '') {
                    if ($first_cond) {
                        $qb->where('1 = 1');
                        $first_cond = false;
                    }
                    $qb->andWhere('d.chapitre = :chapitre')
                    ->setParameter('chapitre', $data->getChapitre());
                }
                if ($data->getCategorie() != '') {
                    if ($first_cond) {
                        $qb->where('1 = 1');
                        $first_cond = false;
                    }
                    $qb->andWhere('d.categorie = :categorie')
                    ->setParameter('categorie', $data->getCategorie());
                }
                if ($data->getPays() != '') {
                    if ($first_cond) {
                        $qb->where('1 = 1');
                        $first_cond = false;
                    }
                    $qb->andWhere('d.pays = :pays')
                    ->setParameter('pays', $data->getPays());
                }
                if ($data->getLieu() != '') {
                    if ($first_cond) {
                        $qb->where('1 = 1');
                        $first_cond = false;
                    }
                    $qb->andWhere('d.lieu = :lieu')
                    ->setParameter('lieu', $data->getLieu());
                }
                if ($data->getIconographie() != '') {
                    if ($first_cond) {
                        $qb->where('1 = 1');
                        $first_cond = false;
                    }
                    $qb->andWhere('d.iconographie = :iconographie')
                    ->setParameter('iconographie', $data->getIconographie());
                }
                if ($data->getMonuments() != '') {
                    if ($first_cond) {
                        $qb->where('1 = 1');
                        $first_cond = false;
                    }
                    $qb->andWhere('d.monuments = :monuments')
                    ->setParameter('monuments', $data->getMonuments());
                }
                if (count($qb->getQuery()->getParameters()) === 0) {
                    $qb->andWhere('1 = 2');
                }

            } else {
                $qb->where('1 = 2');

                if ($data->getSection() != '') {
                    $qb->orWhere('d.section = :section')
                    ->setParameter('section', $data->getSection());
                }
                if ($data->getChapitre() != '') {
                    $qb->orWhere('d.chapitre = :chapitre')
                    ->setParameter('chapitre', $data->getChapitre());
                }
                if ($data->getCategorie() != '') {
                    $qb->orWhere('d.categorie = :categorie')
                    ->setParameter('categorie', $data->getCategorie());
                }
                if ($data->getPays() != '') {
                    $qb->orWhere('d.pays = :pays')
                    ->setParameter('pays', $data->getPays());
                }
                if ($data->getLieu() != '') {
                    $qb->orWhere('d.lieu = :lieu')
                    ->setParameter('lieu', $data->getLieu());
                }
                if ($data->getIconographie() != '') {
                    $qb->orWhere('d.iconographie = :iconographie')
                    ->setParameter('iconographie', $data->getIconographie());
                }
                if ($data->getMonuments() != '') {
                    $qb->orWhere('d.monuments = :monuments')
                    ->setParameter('monuments', $data->getMonuments());
                }
            }

            $qb->leftJoin('d.monuments','m', 'd.monuments = m.id')
               ->add('orderBy', 'm.name ASC');

            $query = $qb->getQuery();

            //$dql = $qb->getDql();

            $monuments = $query->getResult();

            if ('print' === $res){
                $template = 'ApbMonumentsBundle:Default:printresult.html.twig';
            } else {
                $template = 'ApbMonumentsBundle:Default:searchresult.html.twig';
            }

            return $this->render(
                $template,
                array(
                    'titre' => 'Résultats de recherche',
                    'monuments' => $monuments
                    )
            );
        }

        return $this->render(
            'ApbMonumentsBundle:Default:search.html.twig',
            array(
                'titre' => 'Effectuer une recherche',
                'form' => $form->createView()
                )
        );
    }

    /**
     * @Route("/fiche/{id}")
     * @Template()
     */
    public function ficheAction(Monument $monument)
    {
        return array('monument' => $monument, 'result' => array());
    }

    /**
     * @Route("/contact")
     * @Template()
     */
    public function contactAction()
    {
        return array();
    }

    /**
     * @Route("/reset")
     * @Template()
     */
    public function resetAction()
    {
        $session = $this->getRequest()->getSession();
        $session->remove('monuments_exercices');
        $session->remove('monuments_exercices_count');
        $session->remove('monuments_exercices_noms');
        $session->remove('monuments_exercices_lieux');
        $session->remove('monuments_exercices_dates');
        $session->remove('monuments_exercices_reponses');
#        $session->remove('monuments_exercices_niveau');
        $session->remove('monuments_exercices_modalite');

        $url = $this->generateUrl(
            'apb_monuments_default_exercice'
        );
        return $this->redirect($url);
    }

    /**
     * @Route("/exercicestart")
     * @Template()
     */
    public function exercicestartAction(Request $request)
    {
        $session = $this->getRequest()->getSession();
        $session->remove('monuments_exercices');
        $session->remove('monuments_exercices_count');
        $session->remove('monuments_exercices_noms');
        $session->remove('monuments_exercices_lieux');
        $session->remove('monuments_exercices_dates');
        $session->remove('monuments_exercices_reponses');
        $session->remove('monuments_exercices_niveau');
        $session->remove('monuments_exercices_modalite');

        $form = $this->createFormBuilder()
            ->add('niveau', 'choice', array('choices' => array('1' => 'Cour 1', '2' => 'Cour 2', '3' => 'Cour 1 & 2'), 'expanded' => true, 'data' => 3))
            ->add('modalite', 'choice', array('choices' => array('1' => 'Texte libre', '2' => 'QCM'), 'expanded' => true, 'data' => 2))
            ->add('start', 'submit', array('label' => "Démarrer l'exercice"))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $session->set('monuments_exercices_niveau', $form->get('niveau')->getData());
            $session->set('monuments_exercices_modalite', $form->get('modalite')->getData());

            $url = $this->generateUrl(
                'apb_monuments_default_exercice'
            );
            return $this->redirect($url);
        }

        return array(
                    'titre'      => 'Exercices > Identification des monuments',
                    'form' => $form->createView()
                );
    }

    /**
     * @Route("/exercice"))
     * @Template()
     */
    public function exerciceAction()
    {
        $this->get('twig')->addExtension(new \Twig_Extension_Debug);
        $session = $this->getRequest()->getSession();
        $request = $this->get('request');
        $em = $this->getDoctrine()->getEntityManager();

        $niveau = $session->get('monuments_exercices_niveau');
        $modalite = $session->get('monuments_exercices_modalite');

        $noms = array();
        $lieux = array();
        $dates = array();

#        $qcm = true;
        $qcm = $modalite == 2;

        $form_next = $this->createFormBuilder()
            ->add('niveau', 'hidden', array('data' => $niveau))
            ->add('modalite', 'hidden', array('data' => $modalite))
            ->add('Image suivante >>', 'submit')
            ->getForm();
        $form_next->bind($request);

        if ('POST' == $request->getMethod() && $form_next->get('Image suivante >>')->isClicked()) {
            $count = $session->get('monuments_exercices_count');
            $count++;
            $session->set('monuments_exercices_count', $count);
        }

        // initialisation de l'exercice, on selectionne les monuments (qui seront les bonnes réponses) et les autres réponses du QCM si besoin
        if ( !$session->has('monuments_exercices') && !$session->has('monuments_exercices_noms') 
                && !$session->has('monuments_exercices_lieux') && !$session->has('monuments_exercices_dates') )
        {

            $statut = ($niveau == 3) ? ' i.statut > 0 ' : ' i.statut = '.$niveau;
            $stmt = $em->getConnection()
                       ->prepare("SELECT m.id
                                  FROM monuments__monument as m, monuments__images as i, monuments__lieu as l
                                  WHERE m.id = i.monument_id AND m.lieu_id = l.id AND l.name != '' AND m.date != '' AND ".$statut."
                                  ORDER BY RAND() 
                                  LIMIT 9");
            $stmt->execute();

            $monuments = $stmt->fetchAll();
#            print_r( var_dump($monuments) );
            $monument = $em->getRepository('ApbMonumentsBundle:Monument')->find($monuments[0]);
#            $monument_n = $em->getRepository('ApbMonumentsBundle:Monument')->find($monuments[$count-1]);

            if ($qcm) {
                for ($i=0; $i<9; $i++) {
                    $monument_correct = $em->getRepository('ApbMonumentsBundle:Monument')->find($monuments[$i]);
    #            $i = 0;
                    // on collecte les noms pour le QCM
                    $stmt = $em->getConnection()
                               ->prepare("SELECT name
                                          FROM monuments__monuments 
                                          WHERE name != '' AND name != '" . addSlashes($monument_correct->getMonuments()->getName()) . "' 
                                          GROUP BY name 
                                          ORDER BY RAND() 
                                          LIMIT 9");
                    $stmt->execute();
                    $tmp = $stmt->fetchAll();
                    $tmp2 = array();
                    for ($j=0; $j < count($tmp); $j++) {
                        array_push($tmp2, $tmp[$j]['name']);
                    }
                    // on ajoute la bonne réponse
                    array_push($tmp2, $monument_correct->getMonuments()->getName());
                    sort($tmp2);
                    $noms[$i] = $tmp2;

                    // on collecte les lieux pour le QCM
                    $stmt = $em->getConnection()
                               ->prepare("SELECT name
                                          FROM monuments__lieu 
                                          WHERE name != '' AND name != '" . addSlashes($monument_correct->getLieu()->getName()) . "' 
                                          GROUP BY name 
                                          ORDER BY RAND() 
                                          LIMIT 9");
                    $stmt->execute();
                    $tmp = $stmt->fetchAll();
                    $tmp2 = array();
                    for ($j=0; $j < count($tmp); $j++) {
                        array_push($tmp2, $tmp[$j]['name']);
                    }
                    // on ajoute la bonne réponse
                    array_push($tmp2, $monument_correct->getLieu()->getName());
                    sort($tmp2);
                    $lieux[$i] = $tmp2;

                    // on collecte les dates pour le QCM
                    $stmt = $em->getConnection()
                               ->prepare("SELECT date
                                          FROM monuments__monument 
                                          WHERE date != '' AND date != '" . addSlashes($monument_correct->getDate()) . "' 
                                          GROUP BY date 
                                          ORDER BY RAND() 
                                          LIMIT 9");
                    $stmt->execute();
                    $tmp = $stmt->fetchAll();
                    $tmp2 = array();
                    for ($j=0; $j < count($tmp); $j++) {
                        array_push($tmp2, $tmp[$j]['date']);
                    }
                    // on ajoute la bonne réponse
                    array_push($tmp2, $monument_correct->getDate());
                    sort($tmp2);
                    $dates[$i] = $tmp2;
                }
                $session->set('monuments_exercices_noms', $noms);
                $session->set('monuments_exercices_lieux', $lieux);
                $session->set('monuments_exercices_dates', $dates);
                #print_r($noms);
                #print_r("<hr>");
                #print_r($lieux);
                #print_r("<hr>");
                #print_r($dates);
            }

            $session->set('monuments_exercices', $monuments);
            $session->set('monuments_exercices_count', 0);
            $count = 0;
        // fin initialisation
        } else {
            $monuments = $session->get('monuments_exercices');
            $count = $session->get('monuments_exercices_count');
            $noms = $session->get('monuments_exercices_noms');
            $lieux = $session->get('monuments_exercices_lieux');
            $dates = $session->get('monuments_exercices_dates');
        }

        $form = $this->createFormBuilder()
#            ->add('noms', 'choice', array(
#                                        'choices'   => $noms[$count],
#                                        'expanded' => true,
#                                        'required'  => true,))
#            ->add('lieux', 'choice', array(
#                                        'choices'   => $lieux[$count],
#                                        'expanded' => true,
#                                        'required'  => true,))
#            ->add('dates', 'choice', array(
#                                        'choices'   => $dates[$count],
#                                        'expanded' => true,
#                                        'required'  => true,))
            ->add('niveau', 'hidden', array('data' => 3))
            ->add('modalite', 'hidden', array('data' => 1))
            ->add('Valider', 'submit')
            ->getForm();

        $form->bind($request);

        $reponse_nom  = null;
        $reponse_lieu = null;
        $reponse_date = null;

        $reponse_utilisateur_nom  = null;
        $reponse_utilisateur_lieu = null;
        $reponse_utilisateur_date = null;

        $valider = false;

        if ($count < 9) {
            $monument = $em->getRepository('ApbMonumentsBundle:Monument')->find($monuments[$count]);
            if ('POST' == $request->getMethod() && $form->get('Valider')->isClicked()) {
                $valider = true; 
                $reponse_nom  = $monument->getMonuments()->getName();
                $reponse_lieu = $monument->getLieu()->getName();
                $reponse_date = $monument->getDate();
#                $reponse_utilisateur_nom  = $form->get('noms')->getData();
#                $reponse_utilisateur_lieu = $form->get('lieux')->getData();
#                $reponse_utilisateur_date = $form->get('dates')->getData();
                $reponse_utilisateur_nom  = array_key_exists('noms', $_POST['form']) ? $_POST['form']['noms'] : null;
                $reponse_utilisateur_lieu = array_key_exists('lieux', $_POST['form']) ? $_POST['form']['lieux'] : null;
                $reponse_utilisateur_date = array_key_exists('dates', $_POST['form']) ? $_POST['form']['dates'] : null;

                // on conserve les réponses de l'utilisateur
                if ($count == 0) {
                    $reponses = array();
                } else {
                    $reponses = $session->get('monuments_exercices_reponses');
                }
                $reponses[$count] = array('numero' => $count, 'reponses' => array('nom' => $reponse_utilisateur_nom, 'lieu' => $reponse_utilisateur_lieu, 'date' => $reponse_utilisateur_date));
                $session->set('monuments_exercices_reponses', $reponses);
            }
            $session->set('monuments_exercices_count', $count);
        } else { 
        // on doit donner un feed-back
            $repository = $em->getRepository('ApbMonumentsBundle:Monument');
#            $qb = $repository->createQueryBuilder('m');
#            $qb->where('m.id IN (:ids)')
#                ->setParameter('ids', $monuments);
#            $query = $qb->getQuery();
#            $monuments_list = $query->getResult();
            
            
            $monuments_list = array();
            foreach ($monuments as $id) {
                array_push($monuments_list, $repository->find($id));
            }
            
            return $this->render(
                            'ApbMonumentsBundle:Default:exerciceresults.html.twig',
                            array(
                                'titre'     => 'Résultats de l\'exercice',
                                'reponses'  => $session->get('monuments_exercices_reponses'),
                                'monuments' => $monuments_list,
                                'modalite'  => $modalite,
                            )
                        );
        }

        return array(
                'monuments'         => $monuments,
                'monument'          => $monument,
                'count'             => $count,
                'noms'              => $modalite == 2 ? $noms[$count] : null,
                'lieux'             => $modalite == 2 ? $lieux[$count] : null,
                'dates'             => $modalite == 2 ? $dates[$count] : null,
                'form'              => $form->createView(),
                'form_next'         => $form_next->createView(),
                'reponse_nom'       => $reponse_nom,
                'reponse_lieu'      => $reponse_lieu,
                'reponse_date'      => $reponse_date,
                'reponse_utilisateur_nom'   => $reponse_utilisateur_nom,
                'reponse_utilisateur_lieu'  => $reponse_utilisateur_lieu,
                'reponse_utilisateur_date'  => $reponse_utilisateur_date,
                'valider'           => $valider,
                'niveau'            => $niveau,
                'modalite'          => $modalite,
                );
    }
}
