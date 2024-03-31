<?php
namespace App\Service;
 
use Zalo\Zalo;
use Zalo\ZaloEndPoint;
use Zalo\Builder\MessageBuilder;
use Zalo\Common\TransactionTemplateType;
use Zalo\FileUpload\ZaloFile;

class ZaloService
{
    /**
     * @var Zalo
     */
    private $zalo;
    private $accessToken;

    public function __construct(Zalo $zalo)
    {
        $this->zalo = $zalo;
        $this->accessToken = $_ENV['ACCESS_TOKEN'];
    }

    public function getAccessToken()
    {
        $helper = $this->zalo->getRedirectLoginHelper();
        $codeVerifier = $_ENV['CODE_VERIFIER'];
        $zaloToken = $helper->getZaloTokenByOA($codeVerifier);
        $accessToken = $zaloToken->getAccessToken();
        return $accessToken;
    }

    public function getTags()
    {
        $response = $this->zalo->get(ZaloEndPoint::API_OA_GET_LIST_TAG, $this->accessToken, []);
        $result = $response->getDecodedBody();
        return $result;
    }

    public function deleteTag($tagName)
    {
        $data = array('tag_name' => $tagName);
        $response = $this->zalo->post(ZaloEndPoint::API_OA_REMOVE_TAG, $this->accessToken, $data);
        $result = $response->getDecodedBody();

        return $result;
    }

    public function addUserToTag($zaloUserId, $tagName)
    {
        $data = array(
            'user_id' => $zaloUserId,
            'tag_name' => $tagName
        );

        $response = $this->zalo->post(ZaloEndPoint::API_OA_TAG_USER, $this->accessToken, $data);
        $result = $response->getDecodedBody();

        return $result;
    }

    public function removeUserFromTag($zaloUserId, $tagName)
    {
        $data = array(
            'user_id' => '494021888309207992',
            'tag_name' => 'vip'
        );

        $response = $this->zalo->post(ZaloEndPoint::API_OA_REMOVE_USER_FROM_TAG, $this->accessToken, $data);
        $result = $response->getDecodedBody();

        return $result;
    }

    public function getUserProfile($zaloUserId)
    {
        $data = [
            'data' => json_encode(['user_id' => $zaloUserId])
        ];
        $response = $this->zalo->get(ZaloEndPoint::API_OA_GET_USER_PROFILE, $this->accessToken, $data);
        $result = $response->getDecodedBody();

        return $result;
    }

    public function getFollowers($offset = 0, $count = 10)
    {
        $data = [
            'data' => json_encode([
                'offset' => $offset,
                'count' => $count
            ])
        ];

        $response = $this->zalo->get(ZaloEndPoint::API_OA_GET_LIST_FOLLOWER, $this->accessToken, $data);
        $result = $response->getDecodedBody();

        return $result;
    }

    public function getMessages($offset = 0, $count = 10)
    {
        $data = [
            'data' => json_encode([
                'offset' => $offset,
                'count' => $count
            ])
        ];

        $response = $this->zalo->get(ZaloEndPoint::API_OA_GET_LIST_RECENT_CHAT, $this->accessToken, $data);
        $result = $response->getDecodedBody();

        return $result;
    }

    public function getMessagesInConversation($zaloUserId, $offset = 0, $count = 10)
    {
        $data = [
            'data' => json_encode([
                'user_id' => $zaloUserId,
                'offset' => $offset,
                'count' => $count
            ])
        ];

        $response = $this->zalo->get(ZaloEndPoint::API_OA_GET_CONVERSATION, $this->accessToken, $data);
        $result = $response->getDecodedBody();

        return $result;
    }

    public function sendMessage($zaloUserId, $messageText, $buttons = [])
    {
        $msgBuilder = new MessageBuilder(MessageBuilder::MSG_TYPE_TXT);
        $msgBuilder->withUserId($zaloUserId);
        $msgBuilder->withText($messageText);

        foreach ($buttons as $button) {
            // Add DTO later, was not included in Zalo package
            $msgBuilder->addButton($button['tilte'], $button['imageIcon'], $button['action']);
        }

        $msgText = $msgBuilder->build();

        $response = $this->zalo->post(ZaloEndPoint::API_OA_SEND_MESSAGE, $this->accessToken, $msgText);
        $result = $response->getDecodedBody();

        return $result;
    }

    public function sendMessageWithImage($zaloUserId, $messageText, $attachmentId, $buttons = [])
    {
        $msgBuilder = new MessageBuilder(MessageBuilder::MSG_TYPE_MEDIA);
        $msgBuilder->withUserId($zaloUserId);
        $msgBuilder->withText($messageText);
        $msgBuilder->withAttachment($attachmentId);

        foreach ($buttons as $button) {
            // Add DTO later, was not included in Zalo package
            $msgBuilder->addButton($button['tilte'], $button['imageIcon'], $button['action']);
        }

        $msgImage = $msgBuilder->build();
        $response = $this->zalo->post(ZaloEndPoint::API_OA_SEND_MESSAGE, $this->accessToken, $msgImage);
        $result = $response->getDecodedBody();

        return $result;
    }

    public function sendMessageAsList($zaloUserId, $messageText, $buttons = [])
    {
        $msgBuilder = new MessageBuilder(MessageBuilder::MSG_TYPE_LIST);
        $msgBuilder->withUserId($zaloUserId);
        $msgBuilder->withText($messageText);

        foreach ($buttons as $button) {
            // Add DTO later, was not included in Zalo package
            $msgBuilder->addButton($button['tilte'], $button['imageIcon'], $button['action']);
        }

        $msgList = $msgBuilder->build();
        $response = $this->zalo->post(ZaloEndPoint::API_OA_SEND_MESSAGE, $this->accessToken, $msgList);
        $result = $response->getDecodedBody();

        return $result;
    }

    public function sendMessageWithFile($zaloUserId, $fileToken)
    {
        $msgBuilder = new MessageBuilder(MessageBuilder::MSG_TYPE_FILE);
        $msgBuilder->withUserId($zaloUserId);
        $msgBuilder->withFileToken($fileToken);

        $msgFile = $msgBuilder->build();

        $response = $this->zalo->post(ZaloEndPoint::API_OA_SEND_MESSAGE, $this->accessToken, $msgFile);
        $result = $response->getDecodedBody();

        return $result;
    }

    public function sendConsultationMessage($zaloUserId, $messageText)
    {
        $msgBuilder = new MessageBuilder(MessageBuilder::MSG_TYPE_TXT);
        $msgBuilder->withUserId($zaloUserId);
        $msgBuilder->withText($messageText);

        $msgText = $msgBuilder->build();

        $response = $this->zalo->post(ZaloEndPoint::API_OA_SEND_CONSULTATION_MESSAGE_V3, $this->accessToken, $msgText);
        $result = $response->getDecodedBody();

        return $result;
    }

    public function sendConsultationMessageWithImage($zaloUserId, $messageText, $imageUrl)
    {
        $msgBuilder = new MessageBuilder(MessageBuilder::MSG_TYPE_MEDIA);
        $msgBuilder->withUserId($zaloUserId);
        $msgBuilder->withText($messageText);
        $msgBuilder->withMediaUrl($imageUrl);

        $msgImage = $msgBuilder->build();

        $response = $this->zalo->post(ZaloEndPoint::API_OA_SEND_CONSULTATION_MESSAGE_V3, $this->accessToken, $msgImage);
        $result = $response->getDecodedBody();

        return $result;
    }

    public function sendConsultationMessageByUserRequest($zaloUserId, $title, $subtitle, $imageUrl)
    {
        $msgBuilder = new MessageBuilder(MessageBuilder::MSG_TYPE_REQUEST_USER_INFO);
        $msgBuilder->withUserId($zaloUserId);

        $element = array(
            'title' => $title ?? "OA Chatbot (Testing)",
            'subtitle' => $subtitle ?? "Đang yêu cầu thông tin từ bạn",
            'image_url' => $imageUrl ?? "https://stc-oa-chat-adm.zdn.vn/images/request-info-banner.png"
        );
        $msgBuilder->addElement($element);

        $msgText = $msgBuilder->build();

        $response = $this->zalo->post(ZaloEndPoint::API_OA_SEND_CONSULTATION_MESSAGE_V3, $this->accessToken, $msgText);
        $result = $response->getDecodedBody();

        return $result;
    }

    public function sendConsultationMessageWithFile($zaloUserId, $fileToken)
    {
        $msgBuilder = new MessageBuilder(MessageBuilder::MSG_TYPE_FILE);
        $msgBuilder->withUserId($zaloUserId);
        $msgBuilder->withFileToken($fileToken);
        $msgFile = $msgBuilder->build();

        $response = $this->zalo->post(ZaloEndPoint::API_OA_SEND_CONSULTATION_MESSAGE_V3, $this->accessToken, $msgFile);
        $result = $response->getDecodedBody();

        return $result;
    }

    public function sendConsultationMessageWithQuote($zaloUserId, $quoteMessageId)
    {
        $msgBuilder = new MessageBuilder(MessageBuilder::MSG_TYPE_TXT);
        $msgBuilder->withUserId($zaloUserId);

        $msgBuilder->withText('Quote message');
        $msgBuilder->withQuoteMessage($quoteMessageId);

        $msgText = $msgBuilder->build();

        $response = $this->zalo->post(ZaloEndPoint::API_OA_SEND_CONSULTATION_MESSAGE_V3, $this->accessToken, $msgText);
        $result = $response->getDecodedBody();

        return $result;
    }

    public function sendConsultationMessageWithSticker($zaloUserId, $messageText, $stickerId)
    {
        $msgBuilder = new MessageBuilder(MessageBuilder::MSG_TYPE_MEDIA);
        $msgBuilder->withUserId($zaloUserId);
        $msgBuilder->withText($messageText);
        $msgBuilder->withMediaType('sticker');
        $msgBuilder->withAttachment($stickerId);

        $msgSticker = $msgBuilder->build();

        $response = $this->zalo->post(ZaloEndPoint::API_OA_SEND_CONSULTATION_MESSAGE_V3, $this->accessToken, $msgSticker);
        $result = $response->getDecodedBody();

        return $result;
    }

    public function sendTransactionMessage($zaloUserId, $elements = [], $buttons = [])
    {
        $msgBuilder = new MessageBuilder(MessageBuilder::MSG_TYPE_TRANSACTION);
        $msgBuilder->withUserId($zaloUserId);

        $msgBuilder->withTemplateType(TransactionTemplateType::TRANSACTION_ORDER);
        $msgBuilder->withLanguage("VI");

        foreach ($elements as $element) {
            $msgBuilder->addElement($element);
        }

        foreach ($buttons as $button) {
            // Add DTO later, was not included in Zalo package
            $msgBuilder->addButton($button['tilte'], $button['imageIcon'], $button['action']);
        }

        $msgTransaction = $msgBuilder->build();

        $response = $this->zalo->post(ZaloEndPoint::API_OA_SEND_TRANSACTION_MESSAGE_V3, $this->accessToken, $msgTransaction);
        $result = $response->getDecodedBody();

        return $result;
    }

    public function sendPromotionMessage($zaloUserId, $elements = [], $buttons = [])
    {
        $msgBuilder = new MessageBuilder(MessageBuilder::MSG_TYPE_PROMOTION);
        $msgBuilder->withUserId($zaloUserId);

        $msgBuilder->withTemplateType(TransactionTemplateType::TRANSACTION_ORDER);
        $msgBuilder->withLanguage("VI");

        foreach ($elements as $element) {
            $msgBuilder->addElement($element);
        }

        foreach ($buttons as $button) {
            // Add DTO later, was not included in Zalo package
            $msgBuilder->addButton($button['tilte'], $button['imageIcon'], $button['action']);
        }

        $msgPromotion = $msgBuilder->build();

        $response = $this->zalo->post(ZaloEndPoint::API_OA_SEND_PROMOTION_MESSAGE_V3, $this->accessToken, $msgPromotion);
        $result = $response->getDecodedBody();

        return $result;
    }

    public function uploadImage($filePath)
    {
        $data = array('file' => new ZaloFile($filePath));
        $response = $this->zalo->post(ZaloEndPoint::API_OA_UPLOAD_PHOTO, $this->accessToken, $data);
        $result = $response->getDecodedBody();

        return $result;
    }

    public function uploadGif($filePath)
    {
        $data = array('file' => new ZaloFile($filePath));
        $response = $this->zalo->post(ZaloEndPoint::API_OA_UPLOAD_GIF, $this->accessToken, $data);
        $result = $response->getDecodedBody();

        return $result;
    }

    public function uploadPDF($filePath)
    {
        $data = array('file' => new ZaloFile($filePath));
        $response = $this->zalo->post(ZaloEndPoint::API_OA_UPLOAD_FILE, $this->accessToken, $data);
        $result = $response->getDecodedBody();

        return $result;
    }
}