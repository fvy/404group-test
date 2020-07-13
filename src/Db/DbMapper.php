<?php

namespace Fvy\Group404\Db;


class DbMapper
{
    public static $db;

    CONST URLS_TABLE = 'urls';

    function __construct($db)
    {
        self::$db = $db;
    }

    static function isUrlExists($url)
    {
        $query = "SELECT id, url_code"
            . " FROM " . self::URLS_TABLE
            . " WHERE url = :url";

        $params = ["url" => $url];

        $stmt = self::$db->prepare($query);
        $stmt->execute($params);
        $result = $stmt->fetch();

        return (empty($result)) ? false : $result;
    }

    static function insertUrl($url)
    {
        $query = "INSERT INTO " . self::URLS_TABLE
            . " (url, users_id) "
            . " VALUES (:url, :users_id)";

        $params = [
            "url" => $url,
            "users_id" => 1
        ];

        $stmt = self::$db->prepare($query);
        $stmt->execute($params);

        return self::$db->lastInsertId();
    }

    public static function updateShortCode($id, $shortCode)
    {
        if (empty($id) || empty($shortCode)) {
            throw new \Exception("Bad params to update");
        }

        $query = "UPDATE "
            . self::URLS_TABLE . "
            SET url_code = :url_code 
            WHERE id = :id";

        $params = [
            "id"       => $id,
            "url_code" => $shortCode,
        ];

        $stmt = self::$db->prepare($query);
        $stmt->execute($params);
    }

    public static function getUrlByCode($shortCode)
    {
        $params = array(
            "short_code" => $shortCode,
        );

        $stmt = self::$db->prepare("SELECT id, url
            FROM " . self::URLS_TABLE . "
            WHERE url_code = :short_code
            ");
        $stmt->execute($params);
        $result = $stmt->fetch();

        return empty($result) ? false : $result;
    }

}