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

/**
 * Class ContactsRepository
 *
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 */
class ContactsRepository extends EntityRepository
{
    /**
     * @param Contact $contact
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Contact $contact)
    {
        $this->_em->persist($contact);
        $this->_em->flush();
    }

    /**
     * @param $contact
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Contact $contact)
    {
        $this->_em->remove($contact);
        $this->_em->flush();
    }

    /**
     * @return int
     */
    public function getCountOfContacts(): int
    {
        $query = $this->createQueryBuilder('c')->select('count(c.id)')->getQuery();

        return $query->getFirstResult(); //TODO exception
    }
}