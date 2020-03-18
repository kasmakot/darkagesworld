<?


class Database
{
    public static $hDb = null;

    public function __construct($params)
    {
        self::$hDb = mysqli_connect($params['host'], $params['username'],
            $params['password'], $params['name']
        );

        if (array_key_exists('charset', $params)) {
            self::$hDb->set_charset($params['charset']);
        }
    }

    public function getLink()
    {
        return self::$hDb;
    }

    public function __destruct()
    {
        mysqli_close(self::$hDb);
    }

}
