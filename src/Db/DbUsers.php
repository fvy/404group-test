<?php


namespace Fvy\Group404\Db;


class DbUsers
{
    public static $db;
    CONST USER_TABLE = 'users';
    CONST USER_TOKEN_TABLE = 'users_tokens';

    function __construct($db)
    {
        self::$db = $db;
    }

    public static function getIdByToken($token)
    {
        $query = "SELECT user_id
            FROM " . self::USER_TABLE . " 
            INNER JOIN " . self::USER_TOKEN_TABLE . "
            WHERE token_id = :token_id";
        $params = ["token_id" => (int) $token];

        $stmt = self::$db->prepare($query);
        $stmt->execute($params);
        $result = $stmt->fetch();

        return empty($result) ? false : $result['url'];
    }

    public static function getTokenById($id)
    {
        $query = "SELECT token_id
            FROM " . self::USER_TABLE . " 
            INNER JOIN " . self::USER_TOKEN_TABLE . "
            WHERE 
                user_id = :id AND
                isActive = 1
            ";
        $params = ["id" => (int) $id];

        $stmt = self::$db->prepare($query);
        $stmt->execute($params);
        $result = $stmt->fetch();

        return empty($result) ? false : $result['token_id'];
    }

}