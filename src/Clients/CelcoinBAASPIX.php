<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Enums\ClaimStatusEnum;
use WeDevBr\Celcoin\Enums\ClaimTypeEnum;
use WeDevBr\Celcoin\Rules\BAAS\PixCashOut as BAASPixCashOut;
use WeDevBr\Celcoin\Rules\BAAS\RefundPix as BAASRefundPix;
use WeDevBr\Celcoin\Rules\BAAS\RegisterPixKey as BAASRegisterPixKey;
use WeDevBr\Celcoin\Rules\PIX\ClaimAnswer as ClaimAnswerRule;
use WeDevBr\Celcoin\Rules\PIX\ClaimCreate;
use WeDevBr\Celcoin\Types\BAAS\PixCashOut;
use WeDevBr\Celcoin\Types\BAAS\RefundPix;
use WeDevBr\Celcoin\Types\BAAS\RegisterPixKey;
use WeDevBr\Celcoin\Types\PIX\Claim;
use WeDevBr\Celcoin\Types\PIX\ClaimAnswer;

/**
 * Class CelcoinBAASPIX
 * API de Pix do BaaS possui o modulo de Pix Cash-out, através desse modulo você consegue realizar as seguintes operações:
 */
class CelcoinBAASPIX extends CelcoinBaseApi
{
    public const CASH_OUT_ENDPOINT = '/baas-wallet-transactions-webservice/v1/pix/payment';

    public const GET_PARTICIPANT_ENDPOINT = '/baas-wallet-transactions-webservice/v1/pix/participant';

    public const GET_EXTERNAL_KEY_ENDPOINT = '/celcoin-baas-pix-dict-webservice/v1/pix/dict/entry/external/%s';

    public const STATUS_PIX_ENDPOINT = '/baas-wallet-transactions-webservice/v1/pix/payment/status';

    public const REGISTER_PIX_KEY_ENDPOINT = '/celcoin-baas-pix-dict-webservice/v1/pix/dict/entry';

    public const SEARCH_PIX_KEY_ENDPOINT = '/celcoin-baas-pix-dict-webservice/v1/pix/dict/entry/%s';

    public const DELETE_PIX_KEY_ENDPOINT = '/celcoin-baas-pix-dict-webservice/v1/pix/dict/entry/%s';

    public const REFUND_PIX_ENDPOINT = '/baas-wallet-transactions-webservice/v1/pix/reverse';

    public const STATUS_REFUND_PIX_ENDPOINT = '/baas-wallet-transactions-webservice/v1/pix/reverse/status';

    public const CLAIM_DICT = '/celcoin-baas-pix-dict-webservice/v1/pix/dict/claim';

    public const CLAIM_CONFIRM = '/celcoin-baas-pix-dict-webservice/v1/pix/dict/claim/confirm';

    public const CLAIM_CANCEL = '/celcoin-baas-pix-dict-webservice/v1/pix/dict/claim/cancel';

    public const CLAIM_LIST = '/celcoin-baas-pix-dict-webservice/v1/pix/dict/claim/list';

    /**
     * @throws RequestException
     */
    public function cashOut(PixCashOut $data)
    {
        $body = Validator::validate($data->toArray(), BAASPixCashOut::rules($data->initiationType->value));

        return $this->post(
            self::CASH_OUT_ENDPOINT,
            $body
        );
    }

    public function getParticipant(?string $ISPB = null, ?string $name = null)
    {
        return $this->get(
            self::GET_PARTICIPANT_ENDPOINT,
            array_filter([
                'ISPB' => $ISPB,
                'Name' => $name,
            ])
        );
    }

    public function getExternalPixKey(string $account, string $key)
    {
        return $this->get(
            sprintf(self::GET_EXTERNAL_KEY_ENDPOINT, $account),
            [
                'key' => $key,
            ]
        );
    }

    public function statusPix(?string $id = null, ?string $clientCode = null, ?string $endToEndId = null)
    {
        return $this->get(
            self::STATUS_PIX_ENDPOINT,
            array_filter([
                'id' => $id,
                'clientCode' => $clientCode,
                'endToEndId' => $endToEndId,
            ])
        );
    }

    public function registerPixKey(RegisterPixKey $data)
    {
        $body = Validator::validate(array_filter($data->toArray()), BAASRegisterPixKey::rules());

        return $this->post(
            self::REGISTER_PIX_KEY_ENDPOINT,
            $body
        );
    }

    public function searchPixKey(string $account, string $key = '')
    {
        $payload = [
            'key' => $key,
        ];

        return $this->get(
            sprintf(self::SEARCH_PIX_KEY_ENDPOINT, $account),
            array_filter($payload)
        );
    }

    public function deletePixKey(string $account, string $key)
    {
        return $this->delete(
            sprintf(self::DELETE_PIX_KEY_ENDPOINT, $key),
            [
                'account' => $account,
            ]
        );
    }

    public function refundPix(RefundPix $data)
    {
        $body = Validator::validate($data->toArray(), BAASRefundPix::rules());

        return $this->post(
            self::REFUND_PIX_ENDPOINT,
            $body
        );
    }

    public function statusRefundPix(?string $id = null, ?string $clientCode = null, ?string $returnIdentification = null)
    {
        return $this->get(
            self::STATUS_REFUND_PIX_ENDPOINT,
            array_filter([
                'id' => $id,
                'clientCode' => $clientCode,
                'returnIdentification' => $returnIdentification,
            ])
        );
    }

    /**
     * @throws RequestException
     */
    public function claim(Claim $claim): ?array
    {
        $body = Validator::validate($claim->toArray(), ClaimCreate::rules());

        return $this->post(
            self::CLAIM_DICT,
            $body
        );
    }

    /**
     * @throws RequestException
     */
    public function claimConfirm(ClaimAnswer $claim): ?array
    {
        $body = Validator::validate($claim->toArray(), ClaimAnswerRule::rules());

        return $this->post(
            self::CLAIM_CONFIRM,
            $body
        );
    }

    /**
     * @throws RequestException
     */
    public function claimCancel(ClaimAnswer $claim): ?array
    {
        $body = Validator::validate($claim->toArray(), ClaimAnswerRule::rules());

        return $this->post(
            self::CLAIM_CANCEL,
            $body
        );
    }

    /**
     * @throws RequestException
     */
    public function claimConsult(string $claimId): ?array
    {
        $validatedClaim = Validator::validate(['claimId' => $claimId], ['claimId' => ['string', 'uuid']]);

        return $this->get(
            self::CLAIM_DICT.'/'.$validatedClaim['claimId']
        );
    }

    /**
     * @throws RequestException
     */
    public function claimList(array $params = []): ?array
    {
        $validatedParams = Validator::validate($params,
            [
                'DateFrom' => ['sometimes', 'date'],
                'DateTo' => ['sometimes', 'date'],
                'LimitPerPage' => ['sometimes', 'int'],
                'Page' => ['sometimes', 'int'],
                'Status' => ['sometimes', Rule::enum(ClaimStatusEnum::class)],
                'claimType' => ['sometimes', Rule::enum(ClaimTypeEnum::class)],
            ]
        );

        return $this->get(
            self::CLAIM_LIST,
            $validatedParams
        );
    }
}
