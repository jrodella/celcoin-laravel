<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\PIX\COBVCreate;
use WeDevBr\Celcoin\Rules\PIX\COBVGet;
use WeDevBr\Celcoin\Rules\PIX\COBVPayload;
use WeDevBr\Celcoin\Rules\PIX\COBVUpdate as COBVUpdateRules;
use WeDevBr\Celcoin\Types\PIX\COBV;

class CelcoinPIXCOBV extends CelcoinBaseApi
{
    const CREATE_COBV_PIX = '/pix/v1/collection/duedate';
    const GET_COBV_PIX = '/pix/v1/collection/duedate';
    const PAYLOAD_COBV_PIX = '/pix/v1/collection/duedate/payload/%s';
    const UPDATE_COBV_PIX = '/pix/v1/collection/duedate/%d';
    const DELETE_COB_PIX_URL = '/pix/v1/collection/duedate/%d';

    /**
     * @throws RequestException
     */
    final public function createCOBVPIX(COBV $cobv): ?array
    {
        $body = Validator::validate($cobv->toArray(), COBVCreate::rules());
        return $this->post(
            self::CREATE_COBV_PIX,
            $body
        );
    }

    /**
     * @throws RequestException
     */
    final public function getCOBVPIX(array $data): ?array
    {
        $params = Validator::validate($data, COBVGet::rules());
        return $this->get(
            sprintf(
                '%s?%s',
                self::GET_COBV_PIX,
                http_build_query($params)
            ),
        );
    }

    /**
     * @throws RequestException
     */
    final public function payloadCOBVPIX(string $url): ?array
    {
        Validator::validate(compact('url'), COBVPayload::rules());
        return $this->get(
            sprintf(self::PAYLOAD_COBV_PIX, urlencode($url))
        );
    }

    /**
     * @param int $transactionId
     * @param array $body
     * @return array|null
     * @throws RequestException
     */
    final public function updateCOBVPIX(int $transactionId, array $body): ?array
    {
        $params = Validator::validate($body, COBVUpdateRules::rules());
        return $this->put(
            sprintf(self::UPDATE_COBV_PIX, $transactionId),
            $params
        );
    }

    /**
     * @throws RequestException
     */
    final public function deleteCOBVPIX(int $transactionId): ?array
    {
        return $this->delete(
            sprintf(self::DELETE_COB_PIX_URL, $transactionId)
        );
    }

}
