<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 12.3.19
 * Time: 14.15
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Contact;
use Doctrine\ORM\EntityRepository;

class ContactsRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function getContactsList()
    {
        return $this->_em->getRepository(Contact::class)->findAll();
    }

    /**
     * @param $id
     *
     * @return object|null
     */
    public function getContactById($id)
    {
        return $this->_em->getRepository(Contact::class)->find($id);

    }

    /**
     * @param Contact $contact
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createContact(Contact $contact)
    {
        $this->_em->persist($contact);
        $this->_em->flush();
    }

    /**
     * @param $id
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteContact($id)
    {
        $this->_em->remove($id);
        $this->_em->flush();
    }

    public function getCountOfContacts()
    {
        return $this->_em->getRepository(Contact::class); //TODO finish later
    }
}