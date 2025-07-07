<?php

namespace App\Services;

use Midtrans\Snap;


class MidtransService
{
    protected $clientKey;
    protected $serverKey;

    public function __construct()
    {
    }

    /**
     * Create a Snap payment transaction
     *
     * @param array $params
     * @return string snapToken
     * @throws \Exception
     */
    public function createTransaction(array $params): string
    {
        return Snap::getSnapToken($params);
    }

    /**
     * Get the client key
     *
     * @return string
     */
    public function getClientKey(): string
    {
        return $this->clientKey;
    }
}