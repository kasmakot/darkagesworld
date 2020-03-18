<?

include('Autoloader.php');

class Starter
{
    protected $autloader = null;

    public function __construct()
    {
        $this->autoloader = new Autoloader();
    }

    public function run()
    {
        $config = new Config();
        $controller = new Controller($config->getData());
    }
}
