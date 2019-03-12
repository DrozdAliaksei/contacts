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
        $contacts = $this->contactsRepository->findAll();
        $contactsCount = $this->contactsRepository->getCountOfContacts();

        return $this->render('contacts/list.html.twig', ['contacts' => $contacts,'contactsCount' => $contactsCount]);
    }

    /**
     * @Route("/contacts/new", name= "contacts_create_form")
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $this->contactsRepository->save($contact);

            return $this->redirectToRoute('contacts_list');
        }

        return $this->render('contacts/form.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/contacts/{id}/edit", name= "contacts_edit_form",requirements={"id"="\d+"})
     * @param Request $request
     * @param int     $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, int $id)
    {
        $contact = $this->contactsRepository->find($id);
        if (!$contact) {
            throw $this->createNotFoundException('Such contact does not exists');
        }
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $this->contactsRepository->save($contact);

            return $this->redirectToRoute('contacts_list');
        }

        return $this->render('contacts/form.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/contacts/{id}/delete", name= "contact_delete",requirements={"id"="\d+"})
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteAction(int $id)
    {
        $contact = $this->contactsRepository->find($id);
        if (!$contact) {
            throw $this->createNotFoundException('Such contact does not exists');
        }
        $this->contactsRepository->delete($contact);

        return $this->redirectToRoute('contacts_list');
    }
}