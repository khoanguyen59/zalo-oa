<?php

namespace App\Constants;

class WebhookEvent
{
    public const USER_SEND_TEXT = 'user_send_text';
    public const USER_SEND_IMAGE = 'user_send_image';
    public const USER_SEND_LINK = 'user_send_link';
    public const USER_SEND_AUDIO = 'user_send_audio';
    public const USER_SEND_VIDEO = 'user_send_video';
    public const USER_SEND_STICKER = 'user_send_sticker';
    public const USER_SEND_LOCATION = 'user_send_location';
    public const USER_SEND_BUSINESS_CARD = 'user_send_business_card';
    public const USER_SEND_FILE = 'user_send_file';
    public const ANONYMOUS_SEND_TEXT = 'anonymous_send_text';
    public const ANONYMOUS_SEND_IMAGE = 'anonymous_send_image';
    public const ANONYMOUS_SEND_FILE = 'anonymous_send_file';
    public const ANONYMOUS_SEND_STICKER = 'anonymous_send_sticker';
}