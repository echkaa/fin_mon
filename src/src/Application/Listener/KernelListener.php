<?php

namespace App\Application\Listener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\Serializer\SerializerInterface;

class KernelListener
{
    private const RESPONSE_FORMAT = 'json';
    private const RESPONSE_ERROR = 'error';

    public function __construct(
        private SerializerInterface $serializer,
    ) {
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if ($language = $request->getPreferredLanguage()) {
            $request->setLocale($language);
        }

        $params = json_decode($request->getContent(), true) ?? [];
        $request->request->add($params);
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        $response = $event->getResponse();

        if ($response instanceof JsonResponse) {
            $content = json_decode($response->getContent(), true);
            $isError = array_key_exists(self::RESPONSE_ERROR, $content);
            $response->setContent(
                $this->serializer->serialize(
                    data: [
                        $isError ? 'error' : 'result' => $isError ? $content[self::RESPONSE_ERROR] : $content,
                    ],
                    format: self::RESPONSE_FORMAT
                )
            );
        }
    }
    public function onKernelException(ExceptionEvent $event): void
    {
        $error = $event->getThrowable();

        $event->setResponse(
            (new JsonResponse())->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR)->setContent(
                $this->serializer->serialize([
                    'message' => $error->getMessage()
                ], self::RESPONSE_FORMAT)
            )
        );
    }
}
