<?php

namespace WeDevBr\Celcoin\Types\BillPayments;

use WeDevBr\Celcoin\Types\Data;

class Confirm extends Data
{
    public ?int $externalNSU;

    public ?string $externalTerminal;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
