<?php

namespace App\Dto\Zalo;

use Symfony\Component\Validator\Constraints as Assert;

final class SenderDto
{
    /**
     * @var string
     * @Assert\NotNull()
     */
    public $id;
}