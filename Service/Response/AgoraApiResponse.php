<?php

namespace ThirdParts\AgoraBundle\Service\Response;

use Symfony\Component\HttpFoundation\Response;

class AgoraApiResponse implements AgoraApiResponseInterface
{
    protected const CODE_STRING = 'code';
    protected const MESSAGE_STRING = 'message';
    protected const DATA_STRING = 'data';

    /**
     * @var int
     */
    private $code;
    /**
     * @var string|null
     */
    private $message;

    /** @var mixed */
    private $data;

    public function __construct(
        int $code,
        ?string $message,
        $data = null
    ) {
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
    }

    public function response(): array
    {
        return [
            self::CODE_STRING => $this->code,
            self::MESSAGE_STRING => $this->message,
            self::DATA_STRING => $this->data,
        ];
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    public function isResponseForbidden(): bool
    {
        return Response::HTTP_FORBIDDEN === $this->code;
    }

    public function isResponseOk(): bool
    {
        return Response::HTTP_OK === $this->code;
    }

    public function isResponseError(): bool
    {
        return Response::HTTP_INTERNAL_SERVER_ERROR === $this->code;
    }
}
