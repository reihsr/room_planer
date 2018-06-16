<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="room")
 */
class Room
{
    /**
    * @ORM\Column(type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    private $id;
    
    /**
    * @ORM\Column(type="string", length=100)
    */
    private $name;
    
    /**
    * @ORM\Column(type="text")
    */
    private $description;
    
    /**
    * @ORM\OneToMany(targetEntity="RoomDefaultReservation", mappedBy="room")
    */
    private $roomdefaultreservations;

    public function __construct()
    {
        $this->roomdefaultreservations = new ArrayCollection();
    }

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
     *
     * @return Room
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
     * Set description
     *
     * @param string $description
     *
     * @return Room
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add roomdefaultreservation
     *
     * @param \AppBundle\Entity\RoomDefaultReservation $roomdefaultreservation
     *
     * @return Room
     */
    public function addRoomdefaultreservation(\AppBundle\Entity\RoomDefaultReservation $roomdefaultreservation)
    {
        $this->roomdefaultreservations[] = $roomdefaultreservation;

        return $this;
    }

    /**
     * Remove roomdefaultreservation
     *
     * @param \AppBundle\Entity\RoomDefaultReservation $roomdefaultreservation
     */
    public function removeRoomdefaultreservation(\AppBundle\Entity\RoomDefaultReservation $roomdefaultreservation)
    {
        $this->roomdefaultreservations->removeElement($roomdefaultreservation);
    }

    /**
     * Get roomdefaultreservations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoomdefaultreservations()
    {
        return $this->roomdefaultreservations;
    }
    
    /**
     * Render a Room as a string
     *
     * @return String
     */
    public function __toString()
    {
        return $this->getName();
    }
}
