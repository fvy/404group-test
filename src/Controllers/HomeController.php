<?php

namespace Fvy\Group404\Controllers;

use Fvy\Group404\Components\AntiFlood;
use Fvy\Group404\Components\UrlHelper;
use Fvy\Group404\Components\UrlValidator;
use Fvy\Group404\Db\DbMapper;
use Fvy\Group404\Db\DbUsers;
use Fvy\Group404\Db\DbUsersStats;
use Fvy\Group404\Template;

class HomeController
{
    /**
     * Action for home page
     * @param int $param
     * @return bool
     * @throws \Exception
     */
    public function actionIndex($param = 1)
    {
        // by default take user with id = 1
        $token = DbUsers::getTokenById($param);

        $view = new Template();
        $view->properties = [
            'title' => "Safe redirects/Links Shortener",
            'pageName'  => "Links",
            'token' => $token,
        ];

        echo $view->render('Layout');

        return true;
    }

    /**
     * Action for Form
     * @return bool
     * @throws \Exception
     */
    public function actionForm()
    {
//        $antiFlood = new AntiFlood;
        $urlValidator = new UrlValidator;

        $url = $_POST['url'];
        $token = $_POST['token'];
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $userIp = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
        $userReferrer = $_SERVER['HTTP_REFERER'] ?? '';

        if (!$urlValidator->isCorrectUrl($url)) {
            throw new \Exception("Incorrect URL");
        }

        if (empty($token)) {
            throw new \Exception("Empty token");
        }

//        if ($antiFlood->isOverLimit($url, $userAgent, $userIp)) {
//            throw new \Exception("Too many requests from User with token:" . $token);
//        }

        if ([$link_id, $shortCode] = DbMapper::isUrlExists($url)) {
            // Write statistic about found data
            DbUsersStats::insert($link_id, $userAgent, $userIp, $userReferrer, $token);
            // Redirect to $url
            echo "Found short code: {$shortCode}";
        } else {
            $insertedId = DbMapper::insertUrl($url);
            $shortCode = UrlHelper::createShortCode($insertedId);
            echo 'generated URL: ' . $shortCode;
            DbMapper::updateShortCode($insertedId, $shortCode);
        }

        return true;
    }

    public function actionRedirect($shortCode)
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $userIp = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
        $userReferrer = $_SERVER['HTTP_REFERER'] ?? '';

        try {
            $urlValidator = new UrlValidator;

            if ($urlValidator->isCorrectShortUrl($shortCode)) {

                [$link_id, $url] = DbMapper::getUrlByCode($shortCode);

                if (empty($url)) {
                    throw new \Exception("Can't find short code");
                }

                // Write statistic about found data
                DbUsersStats::insert($link_id, $userAgent, $userIp, $userReferrer, null);

                $response = $urlValidator->httpResponseCode($url);
                if (empty($response) && $response == 404) {
                    throw new \Exception("404 Error");
                } elseif ($urlValidator->isCorrectUrl($url)) {
                    header("Location: " . $url);
                    exit;
                }
            }
        } catch (\Exception $e) {
            echo "ERROR: " . $e->getMessage();
            exit;
        }

        return true;
    }

    /**
     * Method for testing 404 error
     */
    function actionShow404()
    {
        header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
        echo "404 ERROR";
        exit;
    }
}

