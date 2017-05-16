<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Person
 *
 * @ORM\Table(name="person")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PersonRepository")
 */
class Person
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


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
     * Set name
     *
     * @param string $name
     * @return Person
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="xml_file_origin", type="string", length=255, nullable=true)
     *
     * @Assert\NotBlank(message="Please, upload a XML file.")
     * @Assert\File(
     *     maxSize = "20M",
     *     mimeTypes = {"text/xml"},
     *     mimeTypesMessage = "Please upload a valid XML file"
     * )
     */
    private $xmlFileName;

    /**
     * Set xmlFileName
     *
     * @param string $imgName
     *
     * @return Person
     */
    public function setXmlFileName($xmlFileName)
    {
        $this->xmlFileName = $xmlFileName;

        return $this;
    }

    /**
     * Get xmlFileName
     *
     * @return string
     */
    public function getXmlFileName()
    {
        return $this->xmlFileName;
    }

    /**
     * @ORM\OneToMany(targetEntity="PersonPhone", mappedBy="person")
     */
    private $phones;

    public function __construct()
    {
        $this->phones = new ArrayCollection();
    }
    

    /**
     * Add phones
     *
     * @param \AppBundle\Entity\PersonPhone $phones
     * @return Person
     */
    public function addPhone(\AppBundle\Entity\PersonPhone $phones)
    {
        $this->phones[] = $phones;

        return $this;
    }

    /**
     * Remove phones
     *
     * @param \AppBundle\Entity\PersonPhone $phones
     */
    public function removePhone(\AppBundle\Entity\PersonPhone $phones)
    {
        $this->phones->removeElement($phones);
    }

    /**
     * Get phones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPhones()
    {
        return $this->phones;
    }
}
