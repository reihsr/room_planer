<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="room_default_reservation")
 */
class RoomDefaultReservation
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
    * @ORM\Column(type="text")
    */
    private $day;
    
    /**
    * @ORM\Column(type="integer")
    */
    private $starttime;
    
    /**
    * @ORM\Column(type="integer")
    */
    private $endtime;
    
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
     * @return RoomDefaultReservation
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
     * @return RoomDefaultReservation
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
     * Set day
     *
     * @param string $day
     *
     * @return RoomDefaultReservation
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return string
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Set starttime
     *
     * @param integer $starttime
     *
     * @return RoomDefaultReservation
     */
    public function setStarttime($starttime)
    {
        $this->starttime = $starttime;

        return $this;
    }

    /**
     * Get starttime
     *
     * @return integer
     */
    public function getStarttime()
    {
        return $this->starttime;
    }

    /**
     * Set endtime
     *
     * @param integer $endtime
     *
     * @return RoomDefaultReservation
     */
    public function setEndtime($endtime)
    {
        $this->endtime = $endtime;

        return $this;
    }

    /**
     * Get endtime
     *
     * @return integer
     */
    public function getEndtime()
    {
        return $this->endtime;
    }

    /**
     * Set users
     *
     * @param \AppBundle\Entity\User $users
     *
     * @return RoomDefaultReservation
     */
    public function setUsers(\AppBundle\Entity\User $users = null)
    {
        $this->users = $users;

        return $this;
    }

    /**
     * Set rooms
     *
     * @param \AppBundle\Entity\Room $rooms
     *
     * @return RoomDefaultReservation
     */
    public function setRooms(\AppBundle\Entity\Room $rooms = null)
    {
        $this->rooms = $rooms;

        return $this;
    }

    /**
     * Set room
     *
     * @param \AppBundle\Entity\Room $room
     *
     * @return RoomDefaultReservation
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
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return RoomDefaultReservation
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
}
