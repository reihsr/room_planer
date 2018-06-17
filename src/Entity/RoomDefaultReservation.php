<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RoomDefaultReservationRepository")
 */
class RoomDefaultReservation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="roomdefaultreservations")
     * @ORM\JoinTable(name="room_default_reservation_user",
     *      joinColumns={@ORM\JoinColumn(name="userId", referencedColumnName="id")}
     * )
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Room", inversedBy="roomdefaultreservations")
     * @ORM\JoinTable(name="room_default_reservation_room",
     *      joinColumns={@ORM\JoinColumn(name="roomId", referencedColumnName="id")}
     * )
     */
    protected $room;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dayOfTheWeek;

    /**
     * @ORM\Column(type="integer")
     */
    private $startTime;

    /**
     * @ORM\Column(type="integer")
     */
    private $endTime;

    public function getId()
    {
        return $this->id;
    }

    public function getDayOfTheWeek(): ?string
    {
        return $this->dayOfTheWeek;
    }

    public function setDayOfTheWeek(?string $dayOfTheWeek): self
    {
        $this->dayOfTheWeek = $dayOfTheWeek;

        return $this;
    }

    public function getStartTime(): ?int
    {
        return $this->startTime;
    }

    public function setStartTime(int $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getEndTime(): ?int
    {
        return $this->endTime;
    }

    public function setEndTime(int $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }
}
