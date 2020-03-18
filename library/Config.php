<?


class Config
{
    public $fileName = 'config.ini';
    public $data = array();

    public function __construct()
    {
        $filePath = APPLICATION_PATH . 'configs/' . $this->fileName;
        $this->data = parse_ini_file($filePath);
    }

    public function getData()
    {
        return $this->data;
    }

}
