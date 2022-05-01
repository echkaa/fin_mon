<?php

namespace App\Presentation\Controller;

use App\Domain\Exception\ValidationException;
use Psr\Http\Message\ResponseInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractController extends BaseController
{
    public function __construct(
        protected MessageBusInterface $messageBus,
        protected SerializerInterface $serializer,
        protected ValidatorInterface $validator,
        protected RequestStack $requestStack
    ) {
    }

    public function response(mixed $response): Response
    {
        if ($response instanceof ResponseInterface) {
            $response = new JsonResponse(
                data: $response->getBody(),
                status: $response->getStatusCode(),
                headers: $response->getHeaders(),
                json: true,
            );
        }

        return $response;
    }

    /**
     * @throws ExceptionInterface
     * @throws ValidationException
     */
    protected function handle(string $command): mixed
    {
        /** @var HandledStamp $handledStamp */
        $handledStamp = $this->dispatch($command)
            ->last(HandledStamp::class);

        return $handledStamp->getResult();
    }

    /**
     * @throws ExceptionInterface
     * @throws ValidationException
     */
    protected function dispatch(string $command): Envelope
    {
        $parameters = $this->requestStack->getCurrentRequest()->attributes->all()
            + $this->requestStack->getCurrentRequest()->query->all()
            + $this->requestStack->getCurrentRequest()->request->all();

        $object = $this->serializer->denormalize($parameters, $command);

        $violation = $this->validator->validate($object);

        if ($violation->count()) {
            throw new ValidationException($violation);
        }

        return $this->messageBus->dispatch($object);
    }
}
