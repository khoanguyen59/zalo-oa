<?php

namespace App\Dto\Zalo;

use Symfony\Component\Validator\Constraints as Assert;

final class MessageDto
{
    /**
     * @var string
     * @Assert\NotNull()
     */
    public $msg_id;

    /**
     * @var string
     * @Assert\NotNull()
     */
    public $text;

    /**
     * @var string
     */
    public $conversation_id;

    /**
     * @var AttachmentDto[]
     */
    public $attachments;
}