<?php


namespace Fvy\Group404\Db;


class DbUsers
{
    public static $db;
    CONST USER_TABLE = 'users';
    CONST USER_TOKEN_TABLE = 'user_tokens';

    function __construct($db)
    {
        self::$db = $db;
    }

    public static function getUserByToken($shortCode)
    {
        $query = "SELECT url
            FROM " . self::URLS_TABLE . "
            WHERE url_code = :short_code";
        $params = ["short_code" => $shortCode];

        $stmt = self::$db->prepare($query);
        $stmt->execute($params);
        $result = $stmt->fetch();

        return empty($result) ? false : $result['url'];
    }

    public static function getTokenById($id)
    {
        $query = "SELECT token_id
            FROM " . self::USER_TABLE . " 
            inner join " . self::USER_TOKEN_TABLE . "
            WHERE user_id = :id";
        $params = ["id" => (int) $id];

        $stmt = self::$db->prepare($query);
        $stmt->execute($params);
        $result = $stmt->fetch();

        return empty($result) ? false : $result['token_id'];
    }

}