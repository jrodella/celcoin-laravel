<?php

namespace WeDevBr\Celcoin\Types\PIX;

use WeDevBr\Celcoin\Types\Data;

class PixReactivateAndResendAllPendingMessages extends Data
{
    public string $dateFrom;
    public int $dateTo;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
