<?php


namespace Fvy\Group404\Db;


class DbMapper
{
    public static $db;
    CONST URLS_TABLE = 'urls';

    private $strDate;
    private $strDateArr;

    function __construct($db)
    {
        self::$db = $db;
    }

    public function setStrDate($date)
    {
        $this->strDate = $date;
    }

    public function getStrDate()
    {
        return $this->strDate;
    }

    /**
     * @param null $startDate
     * @param null $endDate
     * @return mixed
     */
    public function usersList($startDate = null, $endDate = null)
    {
        // filter the dates
        $startDate = $this->filterTheDate($startDate);
        $endDate = $this->filterTheDate($endDate);

        // go with period
        $dateStr = (!empty($startDate) ? 'AND `Date` >= :startDate' : '') . ' ' .
            (!empty($endDate) ? 'AND `Date` <= :endDate' : '');

        $this->setStrDate($dateStr);

        $sth = self::$db->prepare(
            '
            SELECT 
                Id, `Name`, Email, userlvl(id) AS path, EmployerId, 
                TIME_FORMAT(
                    (select sum(`Time`) from timesheet WHERE id=EployeeId ' . $dateStr . '
                    ), "%H:%i:%s"
                ) utime, 
                TIME_FORMAT(
                    (SELECT sum(`Time`) 
                    FROM users
                    LEFT JOIN timesheet ON (Id=EployeeId)
                    WHERE userlvl(id) LIKE CONCAT(CONVERT(path using utf8),"%") ' . $dateStr . '
                    ), 
                    "%H:%i:%s"
                ) AS totalsum,
                Info
            FROM 
                users u
            WHERE 
                u.Id in (select EployeeId from timesheet WHERE 1=1 ' . $dateStr . '
                )                     
            ORDER BY path
            '
        );


        $array = [];
        if (!empty($startDate)) {
            $array += [':startDate' => $startDate];
        }
        if (!empty($endDate)) {
            $array += [':endDate' => $endDate];
        }
        $this->strDateArr = $array;

        $sth->execute($array);

        //$sth->debugDumpParams();

        return $sth->fetchAll();
    }

    /**
     * @param $date
     * @return mixed
     */
    public function filterTheDate($date)
    {
        if (empty($date)) {
            return false;
        }
        $date_arr = explode("-", $date);

        return (checkdate($date_arr[1], $date_arr[2], $date_arr[0])) ? $date : false;
    }

    public static function insert()
    {

    }

    static function isUrlExists($url)
    {
        $query = " SELECT url_code"
            . " FROM " . self::URLS_TABLE
            . " WHERE url = :url";

        $params = ["url" => $url];

        $stmt = self::$db->prepare($query);
        $stmt->execute($params);
        $result = $stmt->fetch();

        return (empty($result)) ? false : $result["url_code"];
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
        $query = "SELECT url
            FROM " . self::URLS_TABLE . "
            WHERE url_code = :short_code";
        $params = array(
            "short_code" => $shortCode,
        );

        $stmt = self::$db->prepare($query);
        $stmt->execute($params);
        $result = $stmt->fetch();

        return empty($result) ? false : $result['url'];
    }

}