<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Entity\Telephone;
use AppBundle\Form\ContactType;
use AppBundle\Form\TelephoneType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class REDController extends Controller
{
    /**
     * @Route("edit/contact/{id}", name="edit_contact")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id)
    {

        $contact = $this->getDoctrine()
            ->getRepository(Contact::class)
            ->find($id);

        if ($contact === null) {
            return $this->redirectToRoute("homepage");
        }

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact->setDateUpdate();
            $em = $this->getDoctrine()->getManager();
            $em->merge($contact);
            $em->flush();

            return $this->redirectToRoute("all_contacts");
        }

        return $this->render('crud/edit.html.twig',
            ['form' => $form->createView(),
                'contact' => $contact]);
    }


    /**
     * @Route("delete/contact/{id}", name="delete_contact")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($id)
    {

        $contact = $this->getDoctrine()
            ->getRepository(Contact::class)
            ->find($id);

        if ($contact === null) {
            return $this->redirectToRoute("homepage");
        }

        $telephones = $this->getDoctrine()->getRepository(Telephone::class)->findBy(array('contact' => $id));

        $em = $this->getDoctrine()->getManager();
        $index = 0;
        while (true) {
            if ($index > sizeof($telephones) - 1) {
                break;
            }
            $em->remove($telephones[$index]);
            $index++;
        }
        $em->remove($contact);
        $em->flush();

        return $this->redirectToRoute("all_contacts");
    }


    /**
     * @Route("edit/phone/{id}", name="edit_phone")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editPhoneAction(Request $request, $id)
    {

        $phone = $this->getDoctrine()
            ->getRepository(Telephone::class)
            ->find($id);

        if ($phone === null) {
            return $this->redirectToRoute("homepage");
        }

        $form = $this->createForm(TelephoneType::class, $phone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->merge($phone);
            $em->flush();

            return $this->redirectToRoute("all_contacts");
        }

        return $this->render('crud/edit_phone.html.twig',
            ['form' => $form->createView(),
                'phone' => $phone]);
    }

    /**
     * @Route("delete/phone/{id}", name="delete_phone")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deletePhoneAction($id)
    {
        $phone = $this->getDoctrine()
            ->getRepository(Telephone::class)
            ->find($id);

        if ($phone === null) {
            return $this->redirectToRoute("homepage");
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($phone);
        $em->flush();
        return $this->redirectToRoute("all_contacts");
    }
}
