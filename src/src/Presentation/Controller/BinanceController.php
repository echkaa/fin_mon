<?php

namespace App\Presentation\Controller;

use App\Application\Command\Binance\Signature\BinanceSignatureCommand;
use App\Application\Command\Binance\StatisticCoins\BinanceStatisticCoinsCommand;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Component\Routing\Annotation\Route;

class BinanceController extends AbstractController
{
    /**
     * @Route("/v1/binance/signature", name="get_signature", methods={"GET"})
     * @OA\Get(summary="Get signature by params")
     * @OA\Response(response=Response::HTTP_OK, description="OK")
     * @Security(name="Bearer")
     * @throws ExceptionInterface
     */
    public function signature(): Response
    {
        return $this->response($this->handle(BinanceSignatureCommand::class));
    }

    /**
     * @Route("/v1/binance/statistic/coins", name="get_statistic_by_coins", methods={"GET"})
     * @OA\Get(summary="Get statistic by coins")
     * @OA\Response(response=Response::HTTP_OK, description="OK")
     * @Security(name="Bearer")
     * @throws ExceptionInterface
     */
    public function statisticCoins(): Response
    {
        return $this->response($this->handle(BinanceStatisticCoinsCommand::class));
    }
}
