<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Entity\Telephone;
use AppBundle\Form\TelephoneType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {

        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("contact/all", name="all_contacts")
     */
    public function all_contacts()
    {

        $contacts = $this->getDoctrine()->getRepository(Contact::class)->findAll();

        return $this->render('contact/all_contacts.html.twig',
            [
                'contacts' => $contacts,
            ]);
    }

    /**
     * @Route("telephones/all/{id}", name="view_telephones")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function view_telephones($id){
        $telephones = $this->getDoctrine()->getRepository(Telephone::class)->findBy(array('contact' => $id));

        return $this->render('contact/all_telephones.html.twig',
            [
                'telephones' => $telephones,
            ]);
    }
}
