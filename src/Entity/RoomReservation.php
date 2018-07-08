<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RoomReservationRepository")
 */
class RoomReservation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $roomId;

    /**
     * @ORM\Column(type="integer")
     */
    private $userId;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $startTime;

    /**
     * @ORM\Column(type="integer")
     */
    private $endTime;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="integer")
     */
    private $approved;

    /**
     * @ORM\Column(type="integer")
     */
    private $roomDefaultReservationId;

    public function getId()
    {
        return $this->id;
    }

    public function getRoomId(): ?int
    {
        return $this->roomId;
    }

    public function setRoomId(int $roomId): self
    {
        $this->roomId = $roomId;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getStartTime(): ?int
    {
        return $this->startTime;
    }

    public function setStartTime(?int $startTime): self
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getApproved(): ?int
    {
        return $this->approved;
    }

    public function setApproved(int $approved): self
    {
        $this->approved = $approved;

        return $this;
    }

    public function getRoomDefaultReservationId(): ?int
    {
        return $this->roomDefaultReservationId;
    }

    public function setRoomDefaultReservationId(int $roomDefaultReservationId): self
    {
        $this->roomDefaultReservationId = $roomDefaultReservationId;

        return $this;
    }
}
