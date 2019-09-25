<?php

namespace SimonKub\Laravel\Notifications\Sipgate;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\ClientInterface as HttpClient;
use SimonKub\Laravel\Notifications\Sipgate\Exceptions\CouldNotSendNotification;

class SipgateClient
{
    /**
     * @var HttpClient
     */
    protected $http;

    /**
     * SipgateClient constructor.
     * @param  HttpClient  $http
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * @param  SipgateMessage  $message
     * @throws CouldNotSendNotification
     */
    public function send(SipgateMessage $message)
    {
        try {
            $this->http->post('sessions/sms', ['json' => $message->toArray()]);
        } catch (GuzzleException $exception) {
            throw CouldNotSendNotification::connectionFailed($exception);
        }
    }
}
