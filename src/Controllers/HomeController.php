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
        // By default take user with id = 1
        $token = DbUsers::getTokenById($param);

        $view = new Template();
        $view->title = 'Safe redirects/Links Shortener';
        $view->pageName = 'Urls of user will here';
        $view->token = $token;

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

        if ([$link_id, $shortCode] = DbMapper::isUrlExists($url)) {
            // Write statistic about found url
            DbUsersStats::insert($link_id, $userAgent, $userIp, $userReferrer, $token);
            // If already found in DB Redirect to the $url
            echo 'Your url found in DB, should we proceed?: <a href="/' . $shortCode . '">' . htmlspecialchars($url) . '</a>';
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
            $antiFlood = new AntiFlood(60);

            if ($urlValidator->isCorrectShortUrl($shortCode)) {
                [$link_id, $url] = DbMapper::getUrlByCode($shortCode);

                if (empty($url)) {
                    throw new \Exception("Can't find short code");
                }

                // Write statistic about found data
                DbUsersStats::insert($link_id, $userAgent, $userIp, $userReferrer, null);

                $response = $urlValidator->httpResponseCode($url);
                $hashArgs = [$userAgent, $userIp, $userReferrer];
                $is404Error = empty($response) || $response == 404;

                if ($is404Error && !$antiFlood->isFlood(...$hashArgs)) {
                    $antiFlood->increaseCounter(...$hashArgs);
                    throw new \Exception("404 Error");
                } elseif ($is404Error && $antiFlood->isFlood(...$hashArgs)) {
                    header("Location: /anti-flood-page/");
                    exit;
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
     * url: http://domain/404error
     */
    function actionShow404()
    {
        header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
        echo "404 ERROR";
        exit;
    }

    /**
     * Method for displaying 404 error
     */
    function actionAntiFlood()
    {
        $view = new Template();
        $view->properties = [
            'title'    => "Anti-flood page",
            'pageName' => "Anti-flood page",
            'body'     => 'Flood attack detected',
        ];

        echo $view->render('Layout404');

        return true;
    }
}

