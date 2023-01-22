<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Horaire;
use AppBundle\Entity\Programme;
use Doctrine\Common\Annotations\Annotation\Required;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class ProgrammeController extends Controller
{
    /**
     * @Route("/programme", name="programme")
     */
    public function programmeAction(Request $request){
        if($request->isMethod('POST')){
            $programme = new Programme();
            $programme->setTitre($request->request->get('titre'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($programme);
            $em->flush();
        }
        $prg = $this->getDoctrine()->getRepository(Programme::class)->findAll();
        return $this->render('admin/programme.html.twig', [
            'programmes' => $prg,
            'horaires' => []
        ]);
    }

    /**
     * @Route("/horaire", name="horaire")
     */
    public function horaireAction(Request $request){
        if($request->isMethod('POST')){
            $horaire = new Horaire();
            $horaire->setJour($request->request->get('jour'));
            $horaire->setHeureDebut(new \DateTime($request->request->get('heure_debut')));
            $horaire->setHeureFin(new \DateTime($request->request->get('heure_fin')));
            $horaire->setProgramme($this->getDoctrine()->getRepository(Programme::class)->find($request->request->get('programme')));
            $em = $this->getDoctrine()->getManager();
            $em->persist($horaire);
            $em->flush();

            $prg = $this->getDoctrine()->getRepository(Programme::class)->findAll();
            $hr = $this->getDoctrine()->getRepository(Horaire::class)->findBy(['id'=>$horaire->getId()]);
            
            return $this->render('admin/programme.html.twig', [
                'programmes' => $prg,
                'horaires' => $hr
            ]);
        }
        return $this->redirectToRoute('programme');
    }
}
