<?php

namespace App\Application\Command\Binance\Signature;

use App\Application\Factory\TokenBinanceFactory;
use App\Application\Service\UserService;
use Exception;
use GuzzleHttp\Psr7\Response as HttpResponse;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class BinanceSignatureHandler implements MessageHandlerInterface
{
    public function __construct(
        private SerializerInterface $serializer,
        private TokenBinanceFactory $tokenBinanceFactory,
        private UserService $userService,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(BinanceSignatureCommand $command): ResponseInterface
    {
        parse_str($command->getParams(), $params);

        $token = $this->tokenBinanceFactory->create(
            publicKey: $this->userService->getCurrentUser()->getSetting()->getBinancePublicKey(),
            privateKey: $this->userService->getCurrentUser()->getSetting()->getBinancePrivateKey(),
            params: $params,
        );

        return new HttpResponse(
            status: Response::HTTP_OK,
            body: $this->serializer->serialize(
                data: [
                    'signature' => $token->getSignature(),
                    'params' => $token->getParamsHttpWithToken(),
                ],
                format: 'json',
            )
        );
    }
}
