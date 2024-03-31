<?php

namespace App\Dto\Zalo;

use App\Dto\InputInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final class WebhookDto implements InputInterface
{
    /**
     * @var string
     * @Assert\NotNull()
     */
    public $app_id;
    
    /**
     * @var SenderDto
     * @Assert\NotNull()
     */
    public $sender;

    /**
     * @var RecipientDto
     * @Assert\NotNull()
     */
    public $recipient;

    /**
     * @var string
     * @Assert\NotNull()
     */
    public $event_name;

    /**
     * @var MessageDto
     * @Assert\NotNull()
     */
    public $message;

    /**
     * @var string
     * @Assert\NotNull()
     */
    public $timestamp;

    /**
     * @var string
     * @Assert\NotNull()
     */
    public $user_id_by_app;
}