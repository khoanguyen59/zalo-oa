<?php
namespace App\Controller;

use App\Dto\Zalo\WebhookDto;
use App\Service\ZaloService;
use App\Service\WebhookService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use OpenApi\Annotations as OA;

class WebhookController
{
    private $zaloService;
    private $webhookService;
    private $serializer;
    private $validator;

    public function __construct(
        ZaloService $zaloService,
        WebhookService $webhookService,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    )
    {
        $this->zaloService = $zaloService;
        $this->webhookService = $webhookService;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * Receive webhook POST from Zalo.
     *
     * @Route("/api/webhook/zalo", methods={"POST"})
     * @OA\Response(
     *     response=200,
     *     description="Returns true if webhook is successfully handled",
     *     @OA\JsonContent(
     *        type="boolean",
     *     )
     * )
     */
    public function handleWebhookZalo(Request $request)
    {
        $headers = $request->headers->all();
        $content = $request->getContent();
        $data = $this->serializer->deserialize($content, WebhookDto::class, 'json');
        $errors = $this->validator->validate($data);
        
        // Calculate the MAC value from received data       
        $isSignatureMatched = $this->webhookService->compareSignature($data, $content, $headers);
        if (!$isSignatureMatched) {
            return new JSONResponse(false);
        }

        $result = $this->webhookService->handleWebhookZalo($data, $content, $headers);

        return new JSONResponse($result);
    }
}