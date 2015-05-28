<?php

namespace Dusk\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller {

    public function indexAction($pageroute) {
        $objPage = $this->getDoctrine()
                ->getRepository('DuskUserBundle:Pages')
                ->findOneBy(array('pageroute' => $pageroute));

        $pageContent = '';
        if ($objPage) {
            $pageContent = $objPage->getPagecontent();
        }
        return $this->render('DuskUserBundle:Page:index.html.twig', array('pageContent' => $pageContent, 'pageroute' => $pageroute));
    }

    public function aboutAction() {
        $em = $this->getDoctrine()->getManager();
        $record = $em->getRepository("DuskUserBundle:Pages")->findBy(array('pageroute' => 'about'));
        return $this->render('DuskUserBundle:Page:about.html.twig', array('record' => $record[0]));
    }

    public function howitworksAction() {
        $em = $this->getDoctrine()->getManager();
        $record = $em->getRepository("DuskUserBundle:Pages")->findBy(array('pageroute' => 'howitworks'));
        return $this->render('DuskUserBundle:Page:howitworks.html.twig', array('record' => $record[0]));
    }

    public function duskteamAction() {
        $objTeam = $this->getDoctrine()
                ->getRepository('DuskUserBundle:Team')
                ->findAll();


        return $this->render('DuskUserBundle:Page:duskteam.html.twig', array('objTeam' => $objTeam));
    }
    
    public function teamDetailAction($id) {
        $objTeam = $this->getDoctrine()->getRepository('DuskUserBundle:Team')->find($id);
        return $this->render('DuskUserBundle:Page:teamDetail.html.twig', array('team' => $objTeam));
    }

    public function mediaAction() {
        $query = $this->getDoctrine()->getRepository('DuskUserBundle:Media')->createQueryBuilder('t')->where('t.is_active = :active')->setParameter('active', 1)->getQuery();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($query, $this->get('request')->query->get('page', 1), 2);
        return $this->render('DuskUserBundle:Page:duskmedia.html.twig', array('pagination' => $pagination));
    }

    public function mediaDetailAction($id) {
        $em = $this->getDoctrine()->getManager();
        $record = $em->getRepository("DuskUserBundle:Media")->find($id);
        return $this->render('DuskUserBundle:Page:duskmediadetail.html.twig', array('record' => $record));
    }
    
    public function testimonialsAction() {
        $query = $this->getDoctrine()->getRepository('DuskUserBundle:Testimonial')->createQueryBuilder('t')->where('t.is_active = :active')->setParameter('active', 1)->getQuery();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($query, $this->get('request')->query->get('page', 1), 3);
        return $this->render('DuskUserBundle:Page:testimonials.html.twig', array('pagination' => $pagination));
    }

    public function contactUsAction(Request $request) {

        $objEnquiry = new \Dusk\UserBundle\Entity\Enquiry();
        $form = $this->createFormBuilder($objEnquiry)
                ->add('type', 'choice', array(
                    'choices' => array(
                        'quote' => 'Need Quote',
                        'query' => 'Queries'
                    ),
                    'multiple' => false,
                    'expanded' => false,
                    'required' => true,
                    'data' => 'query'
                ))
                ->add('name', 'text')
                ->add('email', 'email')
                ->add('phone', 'text')
                ->add('postcode', 'text')
                ->add('message', 'textarea')
                ->getForm();

        // Form Post Action
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $objFormData = $form->getData();
//                echo "<pre>";
//                print_r($objFormData->getEmail());
//                exit;
                // Send an email 
                $message = \Swift_Message::newInstance()
                        ->setSubject('Hello Email')
                        ->setFrom($objFormData->getEmail())
                        ->setTo('enquries@dusk.com')
                        ->setBody(
                        $this->renderView(
                                'DuskUserBundle:Email:email.txt.twig', array('name' => $name)
                ));
                $this->get('mailer')->send($message);


                // Add enquries into  database as well         
                $em = $this->getDoctrine()->getManager();
                $em->persist($objEnquiry);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Your enquiry sent successfully, We will get basck to you soon');
            }
        }

        return $this->render('DuskUserBundle:Page:contactus.html.twig', array('form' => $form->createView()));
    }

    public function musicAction() {
        $em = $this->getDoctrine()->getManager();
        $record = $em->getRepository("DuskUserBundle:Pages")->findBy(array('pageroute' => 'music'));
        return $this->render('DuskUserBundle:Page:music.html.twig', array('record' => $record[0]));
    }
    
    public function streamAction() {
        $em = $this->getDoctrine()->getManager();
        $record = $em->getRepository("DuskUserBundle:Pages")->findBy(array('pageroute' => 'stream247'));
        return $this->render('DuskUserBundle:Page:stream.html.twig', array('record' => $record[0]));
    }
    
    public function tryFreeAction() {
        $em = $this->getDoctrine()->getManager();
        $record = $em->getRepository("DuskUserBundle:Pages")->findBy(array('pageroute' => 'try-it-for-free'));
        return $this->render('DuskUserBundle:Page:tryFree.html.twig', array('record' => $record[0]));
    }
    
    public function multiRoomVenueAction() {
        $em = $this->getDoctrine()->getManager();
        $record = $em->getRepository("DuskUserBundle:Pages")->findBy(array('pageroute' => 'multi-rooms-venues'));
        return $this->render('DuskUserBundle:Page:multiRoomVenue.html.twig', array('record' => $record[0]));
    }
    
    public function pricingAction() {
        
        return $this->render('DuskUserBundle:Page:pricing.html.twig');
    }
    
    public function termandconditionAction() {
        $em = $this->getDoctrine()->getManager();
        $record = $em->getRepository("DuskUserBundle:Pages")->findBy(array('pageroute' => 'terms-and-condition'));
        return $this->render('DuskUserBundle:Page:termsandcondition.html.twig', array('record' => $record[0]));
    }
}
