<?php
/**
 * Created by PhpStorm.
 * User: charl
 * Date: 2016-02-16
 * Time: 09:09
 */

namespace PublicationBundle\Controller;

use PublicationBundle\Entity\Sujet;
use PublicationBundle\Form\SujetType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class PublicationController extends Controller
{
    public function indexAction()
    {
        $rep = $this->getDoctrine()->getRepository('PublicationBundle:Sujet');
        $sujets = $rep->findAll();

        return $this->render("PublicationBundle:Pages:index.html.twig", array('sujets' => $sujets));
    }

    public function addAction(Request $request)
    {
        $sujet = new Sujet();

        $form = $this->createForm(SujetType::class, $sujet);

        if ($form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sujet);
            $em->flush();

            return $this->redirect($this->generateUrl('publication_view_sujet', array('id' => $sujet->getId())));
        }

        return $this->render('PublicationBundle:Publication:Ajout.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function viewSujetAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $sujet = $em->getRepository("PublicationBundle:Sujet")->find($id);

        return $this->render('PublicationBundle:Publication:Sujet.html.twig', array('sujet' => $sujet));
    }

    public function menuAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sujets = $em->getRepository("PublicationBundle:Sujet")->findAll();

        return $this->render('PublicationBundle:Pages:menu.html.twig', array('sujets' => $sujets));
    }

    public function editAction($id, Request $request)
    {
        $sujet = $this->getDoctrine()->getManager()->getRepository('PublicationBundle:Sujet')->find($id);

        $form = $this->createForm(SujetType::class, $sujet);

        if ($form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sujet);
            $em->flush();

            return $this->redirect($this->generateUrl('publication_view_sujet', array('id' => $sujet->getId())));
        }

        return $this->render('PublicationBundle:Publication:Ajout.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}