<?php

namespace Fvy\Group404\Controllers;

use Fvy\Group404\Components\UrlHelper;
use Fvy\Group404\Components\UrlValidator;
use Fvy\Group404\Db\DbMapper;
use Fvy\Group404\Db\DbUsers;
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
        $url = $_POST['url'];
        $token = $_POST['token'];

        if ($shortCode = DbMapper::isUrlExists($url)) {
            // Write statistic about found data
            // link_id (id найденной сущности), user_agent, user_ip, referrer, token_id, timestamp обращения

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
        $urlValidator = new UrlValidator;
        if ($urlValidator->isCorrectShortUrl($shortCode)) {

            $url = DbMapper::getUrlByCode($shortCode);

            if (empty($url)) {
                throw new \Exception("Can't find short code");
            }

            // Write statistic about found data
            // link_id (id найденной сущности), user_agent, user_ip, referrer, token_id, timestamp обращения

            try {
                $urlValidator->isCorrectUrl($url);
                header("Location: " . $url);
                exit;
            } catch (\Exception $e) {
                echo "ERROR: " . $e->getMessage();
            }

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

