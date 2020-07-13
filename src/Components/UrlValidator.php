<?php

namespace Fvy\Group404\Components;

class UrlValidator
{
    private $checkUrlExists;

    function __construct($checkUrlExists = true)
    {
        $this->checkUrlExists = $checkUrlExists;
    }

    public function isCorrectUrl($url)
    {
        if (empty($url)) {
            throw new \Exception("Empty url address");
        }

        if ($this->checkUrlFormat($url) == false) {
            throw new \Exception("Incorrect URL format");
        }

        return true;
    }

    protected function checkUrlFormat($url)
    {
        return filter_var(
            $url,
            FILTER_VALIDATE_URL,
            FILTER_FLAG_HOST_REQUIRED
        );
    }

    public function httpResponseCode($url)
    {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ch);
            $response = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
            curl_close($ch);
        } catch (\Exception $e) {
            throw new \Exception("Request error for URL");
        }

        return $response;
    }

    public function isCorrectShortUrl($code)
    {
        if (empty($code)) {
            throw new \Exception("Empty short code");
        }

        if ($this->validateShortCode($code) == false) {
            throw new \Exception("Incorrect format of code");
        }

        return true;
    }

    protected function validateShortCode($code) {
        return preg_match("|[" . UrlHelper::ALLOWED_CHARS. "]+|", $code);
    }
}