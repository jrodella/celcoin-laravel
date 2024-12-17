<?php

namespace WeDevBr\Celcoin\Rules\PIX;

class ReceiverRules
{
    /**
     * @return array[]
     */
    public static function rules(): array
    {
        return [
            'name' => ['required'],
            'cpf' => ['sometimes', 'required_without:debtor.cnpj'],
            'cnpj' => ['sometimes', 'required_without:debtor.cpf'],
            'postalCode' => ['required'],
            'city' => ['required'],
            'publicArea' => ['required'],
            'state' => ['required'],
            'fantasyName' => ['required_with:cnpj'],
        ];
    }
}
