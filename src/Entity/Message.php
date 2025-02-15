<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Content should not be blank.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "Content cannot be longer than {{ limit }} characters."
    )]
    private ?string $content = null;

    #[ORM\Column]
    #[Assert\NotNull(message: "Sender ID should not be null.")]
    #[Assert\Positive(message: "Sender ID should be a positive integer.")]
    private ?int $sender_id = null;

    #[ORM\Column]
    #[Assert\NotNull(message: "Recipient ID should not be null.")]
    #[Assert\Positive(message: "Recipient ID should be a positive integer.")]
    private ?int $recipient_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getSenderId(): ?int
    {
        return $this->sender_id;
    }

    public function setSenderId(int $sender_id): static
    {
        $this->sender_id = $sender_id;

        return $this;
    }

    public function getRecipientId(): ?int
    {
        return $this->recipient_id;
    }

    public function setRecipientId(int $recipient_id): static
    {
        $this->recipient_id = $recipient_id;

        return $this;
    }
}