<?php
// src/AppBundle/Entity/User.php
 
namespace AppBundle\Entity;
 
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
 
/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Group")
     * @ORM\JoinTable(name="fos_user_user_group",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;
    
    /**
    * @ORM\OneToMany(targetEntity="RoomDefaultReservation", mappedBy="user")
    */
    private $roomdefaultreservations;
 
    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->username;
    }
 
    public function __construct()
    {
        parent::__construct();
        $this->roomdefaultreservations = new ArrayCollection();
    }

    /**
     * Add roomdefaultreservation
     *
     * @param \AppBundle\Entity\RoomDefaultReservation $roomdefaultreservation
     *
     * @return User
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
}
