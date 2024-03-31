<?php

namespace App\Dto\Zalo;

final class PayloadDto
{
    /**
     * @var string
     */
    public $thumbnail;

    /**
     * @var string
     */
    public $url;

    /**
     * @var string
     */
    public $description;

    /**
     * @var CoordinateDto
     */
    public $coordinates;

    /**
     * @var int
     */
    public $size;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $checksum;

    /**
     * @var string
     */
    public $type;
}