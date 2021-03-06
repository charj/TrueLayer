<?php

namespace TrueLayer\Bank\Account;

use Teapot\StatusCode\Http;
use TrueLayer\Data\Balance as Data;
use TrueLayer\Exceptions\OauthTokenInvalid;
use TrueLayer\Request;

class Balance extends Request
{
    /**
     * Get account balance
     *
     * @param string $account_id
     * @return Data
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws OauthTokenInvalid
     */
    public function get($account_id)
    {
        $result = $this->connection
            ->setAccessToken($this->token->getAccessToken())
            ->get("/data/v1/accounts/" . $account_id . "/balance");

        if ((int) $result->getStatusCode() > Http::BAD_REQUEST) {
            throw new OauthTokenInvalid();
        }

        $data = json_decode($result->getBody(), true);

        return new Data($data["results"]);
    }
}
