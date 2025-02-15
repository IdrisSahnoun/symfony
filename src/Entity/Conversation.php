<?php

namespace App\Entity;

use App\Repository\ConversationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ConversationRepository::class)]
class Conversation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotNull(message: "Product ID should not be null.")]
    #[Assert\Positive(message: "Product ID should be a positive integer.")]
    private ?int $product_id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: "Start date should not be null.")]

    private ?\DateTimeInterface $date_start = null;

    #[ORM\Column]
    #[Assert\NotNull(message: "Message ID should not be null.")]
    #[Assert\Positive(message: "Message ID should be a positive integer.")]
    private ?int $message_id = null;

    #[ORM\Column]
    #[Assert\NotNull(message: "Participant should not be null.")]
    #[Assert\Positive(message: "Participant should be a positive integer.")]
    private ?int $participant = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductId(): ?int
    {
        return $this->product_id;
    }

    public function setProductId(int $product_id): static
    {
        $this->product_id = $product_id;

        return $this;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->date_start;
    }

    public function setDateStart(\DateTimeInterface $date_start): static
    {
        $this->date_start = $date_start;

        return $this;
    }

    public function getMessageId(): ?int
    {
        return $this->message_id;
    }

    public function setMessageId(int $message_id): static
    {
        $this->message_id = $message_id;

        return $this;
    }

    public function getParticipant(): ?int
    {
        return $this->participant;
    }

    public function setParticipant(int $participant): static
    {
        $this->participant = $participant;

        return $this;
    }
}