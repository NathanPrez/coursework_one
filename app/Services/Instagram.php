<?php

namespace App\Services;

class Instagram 
{
    private $apiKey;

    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }

    public function getKey($apiKey) {
        return $apiKey;
    }

    public function post($text) {
        $outputString = $this->apiKey." - You just posted to instagram: ".$text;
        return $outputString;
    }
}