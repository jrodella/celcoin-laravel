<?php

namespace WeDevBr\Celcoin\Types\PIX;

use WeDevBr\Celcoin\Types\Data;

class COB extends Data
{
    public string $clientRequestId;

    public string $payerQuestion;

    public string $key;

    public int $locationId;

    public Debtor $debtor;

    public Amount|float|string $amount;

    public Calendar $calendar;

    /**
     * @var AdditionalInformation[]
     */
    public array $additionalInformation;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
