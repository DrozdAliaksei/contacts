<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 12.3.19
 * Time: 10.31
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Form\ContactType;
use AppBundle\Repository\ContactsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactsController extends Controller
{
    /**
     * @var ContactsRepository
     */
    private $contactsRepository;

    /**
     * Contacts constructor.
     *
     * @param ContactsRepository $contactsRepository
     */
    public function __construct(ContactsRepository $contactsRepository)
    {
        $this->contactsRepository = $contactsRepository;
    }

    /**
     * @Route("/contacts" , name ="contacts_list")
     */
    public function contacts()
    {
        $contacts = $this->contactsRepository->getContactsList();

        return $this->render('contacts/list.html.twig', ['contacts' => $contacts,]);
    }

    /**
     * @Route("/contacts/new", name= "contacts_create_form")
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createContact(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class,$contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $this->contactsRepository->createContact($contact);

            return $this->redirectToRoute('contacts_list', [], 301);
        }

        return $this->render('contacts/form.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/contacts/edit/{id}", name= "contacts_edit_form",requirements={"id"="\d+"})
     */
    public function editContact(Request $request, $id = 1)
    {
        $contact = $this->contactsRepository->getContactById($id);
        if (!$contact) {
            throw $this->createNotFoundException('Such contact does not exists');
        }
        $form = $this->createForm(ContactType::class,$contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute('contacts_list', [], 301);
        }
    }
}