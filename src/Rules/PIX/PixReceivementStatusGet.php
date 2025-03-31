<?php

namespace WeDevBr\Celcoin\Rules\PIX;

class PixReceivementStatusGet
{
    /**
     * @return array[]
     */
    public static function rules(): array
    {
        return [
            'endtoEnd' => ['required_without_all:transactionId,transactionIdBrCode,clientRequestId', 'string'],
            'transactionId' => ['required_without_all:endtoEnd,transactionIdBrCode,clientRequestId', 'integer'],
            'transactionIdBrCode' => ['required_without_all:endtoEnd,transactionId,clientRequestId', 'string'],
            'clientRequestId' => ['required_without_all:endtoEnd,transactionId,transactionIdBrCode', 'string'],
        ];
    }
}
