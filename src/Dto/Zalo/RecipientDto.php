<?php

namespace App\Dto\Zalo;

use Symfony\Component\Validator\Constraints as Assert;

final class RecipientDto
{
    /**
     * @var string
     * @Assert\NotNull()
     */
    public $id;
}