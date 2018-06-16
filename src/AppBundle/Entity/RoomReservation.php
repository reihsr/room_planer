<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="room_reservation")
 */
class RoomReservation
{
    /**
    * @ORM\Column(type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="roomdefaultreservations")
     * @ORM\JoinTable(name="room_default_reservation_fos_user",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     * )
     */
    protected $user;
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Room", inversedBy="roomdefaultreservations")
     * @ORM\JoinTable(name="room_default_reservation_room",
     *      joinColumns={@ORM\JoinColumn(name="room_id", referencedColumnName="id")}
     * )
     */
    protected $room;
    
    /**
    * @ORM\Column(type="integer")
    */
    private $startdatetime;
    
    /**
    * @ORM\Column(type="integer")
    */
    private $enddatetime;
    
    /**
    * @ORM\Column(type="text")
    */
    private $date;
    
    /**
    * @ORM\Column(type="integer")
    */
    private $approved;
    
    /**
    * @ORM\Column(type="integer")
    */
    private $room_default_reservation_id;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->rooms = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return RoomReservation
     */
    public function addUser(\AppBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \AppBundle\Entity\User $user
     */
    public function removeUser(\AppBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add room
     *
     * @param \AppBundle\Entity\Room $room
     *
     * @return RoomReservation
     */
    public function addRoom(\AppBundle\Entity\Room $room)
    {
        $this->rooms[] = $room;

        return $this;
    }

    /**
     * Remove room
     *
     * @param \AppBundle\Entity\Room $room
     */
    public function removeRoom(\AppBundle\Entity\Room $room)
    {
        $this->rooms->removeElement($room);
    }

    /**
     * Get rooms
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRooms()
    {
        return $this->rooms;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return RoomReservation
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set room
     *
     * @param \AppBundle\Entity\Room $room
     *
     * @return RoomReservation
     */
    public function setRoom(\AppBundle\Entity\Room $room = null)
    {
        $this->room = $room;

        return $this;
    }

    /**
     * Get room
     *
     * @return \AppBundle\Entity\Room
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * Set startdatetime
     *
     * @param \DateTime $startdatetime
     *
     * @return RoomReservation
     */
    public function setStartdatetime($startdatetime)
    {
        $this->startdatetime = $startdatetime;

        return $this;
    }

    /**
     * Get startdatetime
     *
     * @return \DateTime
     */
    public function getStartdatetime()
    {
        return $this->startdatetime;
    }

    /**
     * Set enddatetime
     *
     * @param \DateTime $enddatetime
     *
     * @return RoomReservation
     */
    public function setEnddatetime($enddatetime)
    {
        $this->enddatetime = $enddatetime;

        return $this;
    }

    /**
     * Get enddatetime
     *
     * @return \DateTime
     */
    public function getEnddatetime()
    {
        return $this->enddatetime;
    }

    /**
     * Set date
     *
     * @param integer $date
     *
     * @return RoomReservation
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return integer
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set approved
     *
     * @param integer $approved
     *
     * @return RoomReservation
     */
    public function setApproved($approved)
    {
        $this->approved = $approved;

        return $this;
    }

    /**
     * Get approved
     *
     * @return integer
     */
    public function getApproved()
    {
        return $this->approved;
    }

    /**
     * Set roomDefaultReservationId
     *
     * @param integer $roomDefaultReservationId
     *
     * @return RoomReservation
     */
    public function setRoomDefaultReservationId($roomDefaultReservationId)
    {
        $this->room_default_reservation_id = $roomDefaultReservationId;

        return $this;
    }

    /**
     * Get roomDefaultReservationId
     *
     * @return integer
     */
    public function getRoomDefaultReservationId()
    {
        return $this->room_default_reservation_id;
    }
}
