<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\NotificationMessageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotificationMessageRepository::class)]
class NotificationMessage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private string $type;

    #[ORM\Column(length: 255)]
    private string $user_id;

    #[ORM\Column(length: 100)]
    private ?string $recipient = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $sender_name = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $message_title = null;

    #[ORM\Column(length: 500)]
    private ?string $message_text = null;

    #[ORM\Column]
    private ?bool $is_sent = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, options: [
        'default' => 'CURRENT_TIMESTAMP'
    ])]
    private ?\DateTimeInterface $created = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRecipient(): ?string
    {
        return $this->recipient;
    }

    public function setRecipient(string $recipient): self
    {
        $this->recipient = $recipient;

        return $this;
    }

    public function getSenderName(): ?string
    {
        return $this->sender_name;
    }

    public function setSenderName(?string $sender_name): self
    {
        $this->sender_name = $sender_name;

        return $this;
    }

    public function getMessageTitle(): ?string
    {
        return $this->message_title;
    }

    public function setMessageTitle(?string $message_title): self
    {
        $this->message_title = $message_title;

        return $this;
    }

    public function getMessageText(): ?string
    {
        return $this->message_text;
    }

    public function setMessageText(string $message_text): self
    {
        $this->message_text = $message_text;

        return $this;
    }

    public function isIsSent(): ?bool
    {
        return $this->is_sent;
    }

    public function setIsSent(bool $is_sent): self
    {
        $this->is_sent = $is_sent;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(?\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getUserId(): ?string
    {
        return $this->user_id;
    }

    public function setUserId(string $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }
}
