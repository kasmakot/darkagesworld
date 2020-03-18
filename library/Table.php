<?

class Table
{
    public function query($sql)
    {
        return Database::$hDb->query($sql);
    }
}
