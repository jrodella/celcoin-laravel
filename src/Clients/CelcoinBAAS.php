<?php

namespace WeDevBr\Celcoin\Clients;

use Carbon\Carbon;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\BAAS\AccountBusiness as BAASAccountBusiness;
use WeDevBr\Celcoin\Rules\BAAS\AccountManagerBusiness as BAASAccountManagerBusiness;
use WeDevBr\Celcoin\Rules\BAAS\AccountManagerNaturalPerson as BAASAccountManagerNaturalPerson;
use WeDevBr\Celcoin\Rules\BAAS\AccountNaturalPerson as BAASAccountNaturalPerson;
use WeDevBr\Celcoin\Rules\BAAS\AccountRelease as BAASAccountRelease;
use WeDevBr\Celcoin\Types\BAAS\AccountBusiness;
use WeDevBr\Celcoin\Types\BAAS\AccountManagerBusiness;
use WeDevBr\Celcoin\Types\BAAS\AccountManagerNaturalPerson;
use WeDevBr\Celcoin\Types\BAAS\AccountNaturalPerson;
use WeDevBr\Celcoin\Types\BAAS\AccountRelease;

/**
 * Class CelcoinBAAS
 * Banking as a Service, ou BaaS, é uma tecnologia cujo objetivo é permitir que qualquer empresa – independentemente do seu ramo de atuação – comece a oferecer produtos financeiros sem a necessidade de ser um banco ou instituição financeira.
 */
class CelcoinBAAS extends CelcoinBaseApi
{
    public const CREATE_ACCOUNT_NATURAL_PERSON = '/onboarding/v1/onboarding-proposal/natural-person';

    public const UPDATE_ACCOUNT_NATURAL_PERSON = '/baas-accountmanager/v1/account/natural-person?Account=%s&DocumentNumber=%s';

    public const GET_INFO_ACCOUNT_NATURAL_PERSON = '/baas-accountmanager/v1/account/fetch';

    public const GET_LIST_INFO_ACCOUNT_NATURAL_PERSON = '/baas-accountmanager/v1/account/fetch-all';

    public const CREATE_ACCOUNT_BUSINESS = '/onboarding/v1/onboarding-proposal/legal-person';

    public const UPDATE_ACCOUNT_BUSINESS = '/baas-accountmanager/v1/account/business?Account=%s&DocumentNumber=%s';

    public const GET_INFO_ACCOUNT_BUSINESS = '/baas-accountmanager/v1/account/fetch-business';

    public const GET_LIST_INFO_ACCOUNT_BUSINESS = '/baas-accountmanager/v1/account/fetch-all-business';

    public const GET_PROPOSAL_FILES = '/onboarding/v1/onboarding-proposal/files';

    public const ACCOUNT_CHECK = '/baas-onboarding/v1/account/check';

    public const DISABLE_ACCOUNT = '/baas-accountmanager/v1/account/status?Account=%s&DocumentNumber=%s';

    public const ACTIVE_ACCOUNT = '/baas-accountmanager/v1/account/status?Account=%s&DocumentNumber=%s';

    public const DELETE_ACCOUNT = '/baas-accountmanager/v1/account/close?%s';

    public const GET_WALLET_BALANCE = '/baas-walletreports/v1/wallet/balance?Account=%s&DocumentNumber=%s';

    public const GET_WALLET_MOVEMENT = '/baas-walletreports/v1/wallet/movement';

    public const CREATE_RELEASE = '/baas-wallet-transactions-webservice/v1/wallet/entry/%s';

    public const INCOME_REPORT = '/baas-accountmanager/v1/account/income-report?Account=%s&CalendarYear=%s';

    public function createAccountNaturalPerson(AccountNaturalPerson $data)
    {
        $body = Validator::validate($data->toArray(), BAASAccountNaturalPerson::rules());

        return $this->post(
            self::CREATE_ACCOUNT_NATURAL_PERSON,
            $data->toArray()
        );
    }

    public function updateAccountNaturalPerson(string $account, string $documentNumber, AccountManagerNaturalPerson $data)
    {
        $body = Validator::validate($data->toArray(), BAASAccountManagerNaturalPerson::rules());

        return $this->put(
            sprintf(self::UPDATE_ACCOUNT_NATURAL_PERSON, $account, $documentNumber),
            $body
        );
    }

    public function getInfoAccountNaturalPerson(?string $account = null, ?string $documentNumber = null)
    {
        return $this->get(
            self::GET_INFO_ACCOUNT_NATURAL_PERSON,
            ['Account' => $account, 'DocumentNumber' => $documentNumber]
        );
    }

    public function getListInfoAccountNaturalPerson(Carbon $dateFrom, Carbon $dateTo, ?int $page = null, ?int $limit = null)
    {
        return $this->get(
            self::GET_LIST_INFO_ACCOUNT_NATURAL_PERSON,
            ['DateFrom' => $dateFrom->format('Y-m-d'), 'DateTo' => $dateTo->format('Y-m-d'), 'Page' => $page, 'Limite' => $limit]
        );
    }

    public function createAccountBusiness(AccountBusiness $data)
    {
        $body = Validator::validate($data->toArray(), BAASAccountBusiness::rules());

        return $this->post(
            self::CREATE_ACCOUNT_BUSINESS,
            $data->toArray()
        );
    }

    public function updateAccountBusiness(string $account, string $documentNumber, AccountManagerBusiness $data)
    {
        $body = Validator::validate($data->toArray(), BAASAccountManagerBusiness::rules());

        return $this->put(
            sprintf(self::UPDATE_ACCOUNT_BUSINESS, $account, $documentNumber),
            $body
        );
    }

    public function getInfoAccountBusiness(?string $account = null, ?string $documentNumber = null)
    {
        return $this->get(
            self::GET_INFO_ACCOUNT_BUSINESS,
            ['Account' => $account, 'DocumentNumber' => $documentNumber]
        );
    }

    public function getListInfoAccountBusiness(Carbon $dateFrom, Carbon $dateTo, ?int $page = null, ?int $limit = null)
    {
        return $this->get(
            self::GET_LIST_INFO_ACCOUNT_BUSINESS,
            ['DateFrom' => $dateFrom->format('Y-m-d'), 'DateTo' => $dateTo->format('Y-m-d'), 'Page' => $page, 'Limite' => $limit]
        );
    }

    public function getProposalFiles(?string $proposalId = null, ?string $clientCode = null)
    {
        return $this->get(
            self::GET_PROPOSAL_FILES,
            ['ProposalId' => $proposalId, 'ClientCode' => $clientCode]
        );
    }

    public function accountCheck(?string $onboardingId = null, ?string $clientCode = null)
    {
        return $this->get(
            self::ACCOUNT_CHECK,
            ['onboardingId' => $onboardingId, 'clientCode' => $clientCode]
        );
    }

    public function disableAccount(string $reason, ?string $account = null, ?string $documentNumber = null)
    {
        return $this->put(
            sprintf(self::DISABLE_ACCOUNT, $account, $documentNumber),
            ['status' => 'BLOQUEADO', 'reason' => $reason]
        );
    }

    public function activeAccount(string $reason, ?string $account = null, ?string $documentNumber = null)
    {
        return $this->put(
            sprintf(self::ACTIVE_ACCOUNT, $account, $documentNumber),
            ['status' => 'ATIVO', 'reason' => $reason]
        );
    }

    public function deleteAccount(string $reason, ?string $account = null, ?string $documentNumber = null)
    {
        $params = http_build_query(
            [
                'Account' => $account,
                'DocumentNumber' => $documentNumber,
                'Reason' => $reason,
            ]
        );

        return $this->delete(
            sprintf(self::DELETE_ACCOUNT, $params),
        );
    }

    public function getWalletBalance(string $account, ?string $documentNumber = null)
    {
        return $this->get(
            sprintf(self::GET_WALLET_BALANCE, $account, $documentNumber),
        );
    }

    public function getWalletMovement(string $account, ?string $documentNumber, Carbon $dateFrom, Carbon $dateTo, ?int $page = 1, ?int $limit = null)
    {
        return $this->get(
            self::GET_WALLET_MOVEMENT,
            [
                'Account' => $account,
                'DocumentNumber' => $documentNumber,
                'DateFrom' => $dateFrom->format('Y-m-d'),
                'DateTo' => $dateTo->format('Y-m-d'),
                'Page' => $page,
                'Limite' => $limit,
            ]
        );
    }

    /**
     * @return array|mixed
     *
     * @throws RequestException
     */
    public function createRelease(string $account, AccountRelease $data)
    {
        $body = Validator::validate($data->toArray(), BAASAccountRelease::rules());

        return $this->post(
            sprintf(self::CREATE_RELEASE, $account),
            $body
        );
    }

    /**
     * @throws RequestException
     */
    public function getIncomeReport(string $account, Carbon $referenceYear): mixed
    {
        return $this
            ->get(
                sprintf(self::INCOME_REPORT, $account, $referenceYear->format('Y'))
            );
    }
}
