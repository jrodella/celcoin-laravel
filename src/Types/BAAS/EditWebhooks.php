<?php

namespace WeDevBr\Celcoin\Types\BAAS;

use WeDevBr\Celcoin\Enums\EntityWebhookBAASEnum;
use WeDevBr\Celcoin\Types\Data;

class EditWebhooks extends Data
{
    public EntityWebhookBAASEnum $entity;

    public string $webhookUrl;

    public string $subscriptionId;

    public ?Auth $auth;

    public ?bool $active;

    public function __construct(array $data = [])
    {
        $data['auth'] = new Auth($data['auth'] ?? []);
        parent::__construct($data);
    }
}
