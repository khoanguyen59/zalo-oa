<?php

namespace App\Dto\Zalo;

use Symfony\Component\Validator\Constraints as Assert;

final class AttachmentDto
{
    /**
     * @var PayloadDto
     */
    public $payload;

    /**
     * @var string
     */
    public $type;
}