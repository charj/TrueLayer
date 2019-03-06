<?php

namespace TrueLayer\Bank;

use TrueLayer\Data\Account;
use TrueLayer\Exceptions\OauthTokenInvalid;
use TrueLayer\Request;

class Accounts extends Request
{
    /**
     * Get all accounts
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws OauthTokenInvalid
     */
    public function getAllAccounts()
    {
        $result = $this->connection
            ->setAccessToken($this->token->getAccessToken())
            ->get("/data/v1/accounts");

        if ((int)$result->getStatusCode() > 400) {
            throw new OauthTokenInvalid();
        }

        $accounts = json_decode($result->getBody(), true);
        $results = array_walk($accounts['results'], function ($value) {
            return new Account($value);
        });

        return $results;
    }
}