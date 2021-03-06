<?php
// src/UserBundle/Entity/Utilisateurs.php

namespace UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="utilisateurs")
 */
class Utilisateurs extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    // ...
    /**
     * @ORM\OneToMany(targetEntity="CarnetBundle\Entity\Contacts", mappedBy="utilisateur", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $contacts;

    public function __construct()
    {
        parent::__construct();
        // your own logic
        $this->contacts = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * @param mixed $contacts
     */
    public function setContacts($contacts)
    {
        $this->contacts = $contacts;
    }

    /**
     * Add contacts
     *
     * @param \CarnetBundle\Entity\Contacts $contacts
     * @return Utilisateurs
     */
    public function addContact(\CarnetBundle\Entity\Contacts $contacts)
    {
        $this->contacts[] = $contacts;

        return $this;
    }

    /**
     * Remove contacts
     *
     * @param \CarnetBundle\Entity\Contacts $contacts
     */
    public function removeContact(\CarnetBundle\Entity\Contacts $contacts)
    {
        $this->contacts->removeElement($contacts);
    }
}
