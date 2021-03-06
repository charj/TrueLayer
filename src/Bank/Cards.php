<?php

namespace TrueLayer\Bank;

use Teapot\StatusCode\Http;
use TrueLayer\Data\Card;
use TrueLayer\Exceptions\OauthTokenInvalid;
use TrueLayer\Request;

class Cards extends Request
{
    /**
     * Get all accounts
     *
     * @return Card|array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws OauthTokenInvalid
     */
    public function get()
    {
        $result = $this->connection
            ->setAccessToken($this->token->getAccessToken())
            ->get("/data/v1/cards");

        if ((int) $result->getStatusCode() > Http::BAD_REQUEST) {
            throw new OauthTokenInvalid();
        }

        $accounts = json_decode($result->getBody(), true);
        $results = array_walk($accounts['results'], function ($value) {
            return new Card($value);
        });

        return $results;
    }
}
