<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ShipOrder
 *
 * @ORM\Table(name="ship_order")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ShipOrderRepository")
 */
class ShipOrder
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="person", type="integer")
     */
    private $person;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set person
     *
     * @param integer $person
     * @return ShipOrder
     */
    public function setPerson($person)
    {
        $this->person = $person;

        return $this;
    }

    /**
     * Get person
     *
     * @return integer 
     */
    public function getPerson()
    {
        return $this->person;
    }
}
