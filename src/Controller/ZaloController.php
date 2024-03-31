<?php
namespace App\Controller;

use App\Service\ZaloService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ZaloController
{
    private $zaloService;

    public function __construct(ZaloService $zaloService)
    {
        $this->zaloService = $zaloService;
    }

    /** 
    * @Route("/api/get/followers") 
    */
    public function getFollowers(Request $request)
    {
        $return = $this->zaloService->getFollowers(0, 10);
        return new JSONResponse($return);
    }
}