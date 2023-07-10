<?php

namespace WeDevBr\Celcoin\Clients;

use Carbon\Carbon;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;

/**
 * Class CelcoinReport
 * Essa API possibilita que seja realizada a consulta de tipos de arquivos de conciliação e consulta de extrato consolidado..
 * @package WeDevBr\Celcoin
 */
class CelcoinReport extends CelcoinBaseApi
{
    const GET_CONCILIATION_FILE_TYPES_ENDPOINT = '/tools-conciliation/v1/exportfile/types';
    const CONCILIATION_FILE_ENDPOINT = '/tools-conciliation/v1/exportfile';
    const CONSOLIDATED_STATEMENT_ENDPOINT = '/tools-conciliation/v1/ConsolidatedStatement';

    public function getConciliationFileTypes()
    {
        return $this->get(self::GET_CONCILIATION_FILE_TYPES_ENDPOINT);
    }

    public function conciliationFile(int $type, Carbon $date, ?int $page = null, ?int $limit = null)
    {
        return $this->get(
            self::CONCILIATION_FILE_ENDPOINT,
            [
                'filetype' => $type,
                'accountdate' => $date->format('Y-m-d'),
                'page' => $page,
                'quantity' => $limit,
            ]
        );
    }

    public function consolidatedStatement(Carbon $start, Carbon $end, ?int $page = null, ?int $limit = null)
    {
        return $this->get(
            self::CONSOLIDATED_STATEMENT_ENDPOINT,
            [
                'startDate' => $start->format('Y-m-d'),
                'endDate' => $end->format('Y-m-d'),
                'page' => $page,
                'quantity' => $limit,
            ]
        );
    }
}
