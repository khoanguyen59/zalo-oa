<?php
namespace App\Service;

use App\Constants\WebhookEvent;
use App\Dto\Zalo\WebhookDto;
use Zalo\Zalo;

class WebhookService
{

    /**
     * @var Zalo
     */
    private $zalo;
    private $accessToken;
    private $secretKey;

    public function __construct(Zalo $zalo)
    {
        $this->zalo = $zalo;
        $this->accessToken = $_ENV['ACCESS_TOKEN'];
        $this->secretKey = $_ENV['SECRET_KEY'];
    }

    public function handleWebhookZalo(WebhookDto $data, $content, $headers)
    {
        if ( 0 < strlen($content) && isset($headers["X-ZEvent-Signature"]) ) {
            switch ($data->event_name) {
                case WebhookEvent::USER_SEND_TEXT:
                case WebhookEvent::USER_SEND_IMAGE:
                case WebhookEvent::USER_SEND_LINK:
                case WebhookEvent::USER_SEND_AUDIO:
                case WebhookEvent::USER_SEND_VIDEO:
                case WebhookEvent::USER_SEND_STICKER:
                case WebhookEvent::USER_SEND_LOCATION:
                case WebhookEvent::USER_SEND_BUSINESS_CARD:
                case WebhookEvent::USER_SEND_FILE:
                    $this->handleUserSendTextEvent($data);
                    break;
                case WebhookEvent::ANONYMOUS_SEND_TEXT:
                case WebhookEvent::ANONYMOUS_SEND_IMAGE:
                case WebhookEvent::ANONYMOUS_SEND_FILE:
                case WebhookEvent::ANONYMOUS_SEND_STICKER:
                    $this->handleAnonymousSendTextEvent($data);
                    break;
            }    
        }

        return false;
    }

    private function handleUserSendTextEvent(WebhookDto $data)
    {
        // TODO: Send data to CRM to create task
        var_dump('TODO: Send data to CRM to create task');
    }

    private function handleAnonymousSendTextEvent(WebhookDto $data)
    {
        // TODO: Send data to CRM to create task
        var_dump('TODO: Send data to CRM to create task');
    }

    public function compareSignature(WebhookDto $data, $content, $headers)
    {
        // Calculate the MAC value from received data       
        $calculatedHash = 'mac=' . hash( "sha256", $data->app_id . $content . $data->timestamp . $this->secretKey);        
        $hashFromHeader = $headers["X-ZEvent-Signature"];
        $isMatched = 0 === strcmp($calculatedHash, $hashFromHeader);
        return $isMatched;
    }
}