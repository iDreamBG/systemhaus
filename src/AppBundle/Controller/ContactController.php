<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Entity\Telephone;
use AppBundle\Form\ContactType;
use AppBundle\Form\TelephoneType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends Controller
{
    /**
     * @Route("create", name="contact_create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {


            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();


            $id =  $contact->getId();

            $currentContact = $this->getDoctrine()->getRepository(Contact::class)->find($id);

            return $this->render("contact/complete_process.html.twig",
                [ 'currentContact' => $currentContact]
            );
        }
        return $this->render('contact/create.html.twig',
            ['form' => $form->createView()]);

    }

    /**
     * @Route("add/phone/{id}", name="add_phone")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addPhone(Request $request, $id){

        $telephone = new Telephone();
        $form = $this->createForm(TelephoneType::class, $telephone);
        $form->handleRequest($request);

        if($form->isSubmitted()){

            $idInt = intval($id);
            $currentContact = $this->getDoctrine()->getRepository(Contact::class)->find($idInt);
            $telephone->setContact($currentContact);
            $em = $this->getDoctrine()->getManager();
            $em->persist($telephone);
            $em->flush();

            return $this->render('default/index.html.twig');
        }

        $currentContact = $this->getDoctrine()->getRepository(Contact::class)->find($id);

        return $this->render('contact/add_telephone.html.twig',
            [
                 'currentContact' => $currentContact,
                'form' => $form->createView(),
            ]);

    }
}
