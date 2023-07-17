<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\PIX\PaymentEmvRules;
use WeDevBr\Celcoin\Rules\PIX\PaymentEndToEndRules;
use WeDevBr\Celcoin\Types\PIX\PaymentEmv;
use WeDevBr\Celcoin\Types\PIX\PaymentEndToEnd;

class CelcoinPIXPayment extends CelcoinBaseApi
{
    const END_TO_END_PAYMENT_ENDPOINT = '/pix/v1/payment/endToEnd';
    const EMV_PAYMENT_ENDPOINT = '/pix/v1/emv';

    /**
     * @param PaymentEndToEnd $params
     * @return array|null
     * @throws RequestException
     */
    final public function endToEndPayment(PaymentEndToEnd $params): ?array
    {
        $body = Validator::validate($params->toArray(), PaymentEndToEndRules::rules());
        return $this->post(
            self::END_TO_END_PAYMENT_ENDPOINT,
            $body
        );
    }

    /**
     * @throws RequestException
     */
    final public function emvPayment(PaymentEmv $params): ?array
    {
        $body = Validator::validate($params->toArray(), PaymentEmvRules::rules());
        return $this->post(
            self::EMV_PAYMENT_ENDPOINT,
            $body
        );
    }
}
