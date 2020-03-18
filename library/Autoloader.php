<?

class Autoloader
{
    public function __construct()
    {
        spl_autoload_register(array($this, 'autoload'));
    }

    protected function autoload($class)
    {
        $path = '';

        if ($pos = strpos($class, 'Model')) {
            $path = strtolower(substr($class, 0, $pos)) . '/';
        }

        include $path . $class . '.php';
    }
}
