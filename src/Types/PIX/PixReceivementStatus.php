<?php

namespace WeDevBr\Celcoin\Types\PIX;

use WeDevBr\Celcoin\Types\Data;

class PixReceivementStatus extends Data
{
    public string $endtoEnd;

    public int $transactionId;

    public string $transactionIdBrCode;

    public string $clientRequestId;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
