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

        if ($this->checkUrlExists && !$this->verifyUrlExists($url)) {
            throw new \Exception("404 - Not found URL");
        }
    }

    protected function checkUrlFormat($url)
    {
        return filter_var(
            $url,
            FILTER_VALIDATE_URL,
            FILTER_FLAG_HOST_REQUIRED
        );
    }

    protected function verifyUrlExists($url)
    {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ch);
            $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
        } catch (\Exception $e) {
            throw new \Exception("Request error for URL");
        }

        return !empty($response) && $response != 404;
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