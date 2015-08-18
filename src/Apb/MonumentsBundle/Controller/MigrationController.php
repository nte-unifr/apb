<?php

namespace Apb\MonumentsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Response;

use Apb\MonumentsBundle\Entity\Monument;
use Apb\MonumentsBundle\Entity\Categorie;
use Apb\MonumentsBundle\Entity\Chapitre;
use Apb\MonumentsBundle\Entity\Iconographie;
use Apb\MonumentsBundle\Entity\Monuments;
use Apb\MonumentsBundle\Entity\Lieu;
use Apb\MonumentsBundle\Entity\Pays;
use Apb\MonumentsBundle\Entity\Section;
use Apb\MonumentsBundle\Entity\MonumentImages;

class MigrationController extends Controller
{
    /**
     * @Route("/_migration")
     */
    public function migrationAction()
    {
        # à commenter pour exécuter la migration.
        return new Response('<html><body><h1>NOP!</h1></body></html>');
        exit();

        // paramètre à changer à "true" pour rendre les données persistantes dans la BD
        // par défaut : $PERSIST = false;
#		$PERSIST = false;
		$PERSIST = true;

        $em = $this->getDoctrine()->getManager();

        $monuments = $em->getRepository('ApbMonumentsBundle:OldMonuments')->findAll();
        
        // il faut parcourir l'ancienne table monuments et en extraire les catégories, 
        // chapitre, iconographie, images, lien, monuments, pays et section.
        // remplir la nouvelle table et lié le monument à l'enregistrement correspondant.
        foreach ($monuments as $monument) {
            print_r($monument->getId() . ' - ' . $monument->getMonuments().'<br>');

            $category = $em->getRepository('ApbMonumentsBundle:Categorie')->findOneByName($monument->getCategorie());
            if (!$category) {
                $category = new Categorie();
                $category->setName($monument->getCategorie());
                if ($PERSIST) {
                    $em->persist($category);
                    $em->flush();
                }
                print_r("<br>**************** New Catagorie: ".$category->getName());
            }
            $monument->setIdCategorie($category);

            $chapitre = $em->getRepository('ApbMonumentsBundle:Chapitre')->findOneByName($monument->getChapitre());
            if (!$chapitre) {
                $chapitre = new Chapitre();
                $chapitre->setName($monument->getChapitre());
                if ($PERSIST) {
                    $em->persist($chapitre);
                    $em->flush();
                }
                print_r("<br>**************** New chapitre: ".$chapitre->getName());
            }
            $monument->setIdChapitre($chapitre);

            $iconographie = $em->getRepository('ApbMonumentsBundle:Iconographie')->findOneByName($monument->getIconographie());
            if (!$iconographie) {
                $iconographie = new Iconographie();
                $iconographie->setName($monument->getIconographie());
                if ($PERSIST) {
                    $em->persist($iconographie);
                    $em->flush();
                }
                print_r("<br>**************** New iconographie: ".$iconographie->getName());
            }
            $monument->setIdIconographie($iconographie);

            $monumnt = $em->getRepository('ApbMonumentsBundle:Monuments')->findOneByName($monument->getMonuments());
            if (!$monumnt) {
                $monumnt = new Monuments();
                $monumnt->setName($monument->getMonuments());
                if ($PERSIST) {
                    $em->persist($monumnt);
                    $em->flush();
                }
                print_r("<br>**************** New monument: ".$monumnt->getName());
            }
            $monument->setIdMonuments($monumnt);

            $lieu = $em->getRepository('ApbMonumentsBundle:Lieu')->findOneByName($monument->getLieu());
            if (!$lieu) {
                $lieu = new Lieu();
                $lieu->setName($monument->getLieu());
                if ($PERSIST) {
                    $em->persist($lieu);
                    $em->flush();
                }
                print_r("<br>**************** New lieu: ".$lieu->getName());
            }
            $monument->setIdLieu($lieu);

            $pays = $em->getRepository('ApbMonumentsBundle:Pays')->findOneByName($monument->getPays());
            if (!$pays) {
                $pays = new Pays();
                $pays->setName($monument->getPays());
                if ($PERSIST) {
                    $em->persist($pays);
                    $em->flush();
                }
                print_r("<br>**************** New pays: ".$pays->getName());
            }
            $monument->setIdPays($pays);

            $section = $em->getRepository('ApbMonumentsBundle:Section')->findOneByName($monument->getSection());
            if (!$section) {
                $section = new Section();
                $section->setName($monument->getSection());
                if ($PERSIST) {
                    $em->persist($section);
                    $em->flush();
                }
                print_r("<br>**************** New section: ".$section->getName());
            }
            $monument->setIdSection($section);

            if ($PERSIST || 1) {
                $em->persist($monument);
                $em->flush();
            }

#print_r("<hr>");
#print_r($monument);

        }

        return new Response('<html><body><h1>Conversion terminée!</h1></body></html>');
    }
    /**
     * @Route("/_migration_images")
     */
    public function migrationImagesAction()
    {
        # à commenter pour exécuter la migration.
        return new Response('<html><body><h1>NOP!</h1></body></html>');
        exit();

		ini_set('max_execution_time', "3600"); // (1 hour) This script can take very long to execute!!!
        // paramètre à changer à "true" pour rendre les données persistantes dans la BD
        // par défaut : $PERSIST = false;
#		$PERSIST = false;
		$PERSIST = true;

        $em = $this->getDoctrine()->getManager();

        $monuments = $em->getRepository('ApbMonumentsBundle:Monument')->findAll();
        
        // il faut parcourir l'ancienne table monuments et en extraire les catégories, 
        // chapitre, iconographie, images, lien, monuments, pays et section.
        // remplir la nouvelle table et lié le monument à l'enregistrement correspondant.
        foreach ($monuments as $monument) {
            // On récupère le repository
            $repository = $this->getDoctrine()->getManager()->getRepository('Application\Sonata\MediaBundle\Entity\Media');
            $qb = $repository->createQueryBuilder('m');
            $qb->where("m.name LIKE :name AND m.context = 'monuments'")
            ->setParameter('name', $monument->getId().'\_%');
            $query = $qb->getQuery();
            $medias = $query->getResult();
            
            foreach ($medias as $media) {
                $monument_image = new MonumentImages();
                $monument_image->setFiche($monument);
                $monument_image->setMedia($media);
                
                /* données pour les exercices */
                $nom_image = explode('_', $media->getName());
                $conn = $this->container->get('database_connection');
                $sql = "SELECT * FROM images WHERE path = 'archeoImages/". $nom_image[0] ."/". $nom_image[1] . "'";
                $rows = $conn->query($sql);
                while ($row = $rows->fetch()) {
#                    echo $row['path'] . " - " . $row['statut'] . " - " . $row['date'];
                    $monument_image->setDate($row['date']);
                    $monument_image->setStatut($row['statut']);
                }
                
                $monument->addImage($monument_image);

                if ($PERSIST) {
                    $em->persist($monument);
                    $em->flush();
                }
            }

#print_r("<hr>");
#print_r($monument);

        }

        return new Response('<html><body><h1>Conversion terminée!</h1></body></html>');
    }

}
