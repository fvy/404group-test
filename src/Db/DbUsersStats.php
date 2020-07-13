<?php


namespace Fvy\Group404\Db;

/**
 * Class DbUsersStats
 * @package Fvy\Group404\Db
 */
class DbUsersStats
{
    public static $db;
    const URLS_STATS_TABLE = 'urls_stats';
    const URLS_STATS_AGENTS_TABLE = 'urls_stats_agents';
    const URLS_STATS_IPS_TABLE = 'urls_stats_ips';
    const URLS_STATS_REFERRERS_TABLE = 'urls_stats_referrers';
    const USERS_TOKENS_TABLE = 'users_tokens';

    function __construct($db)
    {
        self::$db = $db;
    }

    /**
     * @param $urlId
     * @param $userAgent
     * @param $userIp
     * @param $userReferrer
     * @param $userToken
     * @return mixed
     */
    static function insert($urlId, $userAgent, $userIp, $userReferrer, $userToken)
    {
        self::$db->beginTransaction();

        try {
            $agent_id = self::replaceAgent($userAgent);
            $ip_id = self::replaceIp($userIp);
            $referrer_id = self::replaceReferrer($userReferrer);
            if ($userToken !== null) {
                $token_id = self::getIdByToken($userToken);
            }

            $query = "REPLACE INTO " . self::URLS_STATS_TABLE . "
                (url_id, ip_id, token_id, agent_id, referrer_id)
                VALUES 
                (:url_id, :ip_id, :token_id, :agent_id, :referrer_id)
            ";

            $params = [
                "url_id"      => $urlId,
                "agent_id"    => $agent_id,
                "ip_id"       => $ip_id,
                "referrer_id" => $referrer_id,
                "token_id"    => $token_id ? $token_id : $userToken,
            ];

            $stmt = self::$db->prepare($query);
            $stmt->execute($params);

            self::$db->commit();
        } catch (\Exception $e) {
            echo "<pre>Can't write statistic: <br>" . $e->getTraceAsString();
            self::$db->rollBack();
        }

        return true;
    }

    /**
     * @param $userAgent
     * @return int
     */
    static function replaceAgent($userAgent): int
    {
        $query = "INSERT INTO " . self::URLS_STATS_AGENTS_TABLE . "
                (user_agent)
                VALUES 
                (:user_agent)
                ON DUPLICATE KEY UPDATE updated_at = NOW()";

        $params = [
            "user_agent" => $userAgent,
        ];

        $stmt = self::$db->prepare($query);
        $stmt->execute($params);

        return self::$db->lastInsertId();
    }

    /**
     * @param $userReferrer
     * @return int
     */
    static function replaceReferrer($userReferrer): int
    {
        $query = "INSERT INTO " . self::URLS_STATS_REFERRERS_TABLE . "
                (user_referrer)
                VALUES 
                (:user_referrer)
                ON DUPLICATE KEY UPDATE updated_at = NOW()";

        $params = [
            "user_referrer" => $userReferrer,
        ];

        $stmt = self::$db->prepare($query);
        $stmt->execute($params);

        return self::$db->lastInsertId();
    }

    /**
     * @param $userIp
     * @return int
     */
    static function replaceIp($userIp): int
    {
        $query = "INSERT INTO " . self::URLS_STATS_IPS_TABLE . "
                (user_ip)
                VALUES 
                (:user_ip)
                ON DUPLICATE KEY UPDATE updated_at = NOW()";

        $params = [
            "user_ip" => $userIp,
        ];

        $stmt = self::$db->prepare($query);
        $stmt->execute($params);

        return self::$db->lastInsertId();
    }

    /**
     * @param $token
     * @return int
     */
    static function getIdByToken($token): int
    {
        $query = "SELECT id FROM
            " . self::USERS_TOKENS_TABLE . "
            WHERE  
            token_id =:token";

        $params = [
            "token" => $token,
        ];

        $stmt = self::$db->prepare($query);
        $stmt->execute($params);
        $result = $stmt->fetch();

        return $result['id'];
    }
}