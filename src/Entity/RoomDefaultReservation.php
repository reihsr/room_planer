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
     * @ORM\Column(type="integer", nullable=false)
     * )
     */
    protected $userId;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * )
     */
    protected $roomId;

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

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getRoomId()
    {
        return $this->roomId;
    }

    /**
     * @param mixed $roomId
     */
    public function setRoomId($roomId): void
    {
        $this->roomId = $roomId;
    }
}
