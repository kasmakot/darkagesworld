<?

class Controller
{
    // TODO maybe static?
    public $queries = array(
        'controller' => 'index',
        'action' => 'index'
    );

    public $configData = array();
    public $database = null;

    protected $_controllerName = 'index';

    // TODO GLOBAL param
    const CONTROLLERS_DIR = 'application/controllers/';
    const DEFAULT_CONTROLLER = 'index';

    public function __construct($data = array())
    {
        $this->database = array_key_exists('db', $data)
            ? new Database($data['db'])
            : null;

        $this->configData = $data;
        $this->_parseQuery();
        $this->_runController();

        $this->init();
    }
    
    public function init()
    {
    }

    public function isControllerExists($controllerName)
    {
        return file_exists(Controller::CONTROLLERS_DIR
            . ucfirst($controllerName) . 'Controller.php'
        );
    }

    public function getControllerName()
    {
        return $this->_controllerName;
    }

    protected function _parseQuery()
    {
        $urlQueries = explode('/', $_SERVER['REQUEST_URI']);

        if (count($urlQueries) > 1) {
            $this->queries['controller'] = $urlQueries[1];
        }
        if (count($urlQueries) > 2) {
            $this->queries['action'] = $urlQueries[2];
        }
        for ($i = 3; $i < count($urlQueries) - 1; $i += 2) {
            $this->queries[$urlQueries[$i]] = $urlQueries[$i+1];
        } 
    }

    protected function _runController()
    {
        $this->_controllerName = (array_key_exists('controller', $this->queries)
            && $this->isControllerExists($this->queries['controller'])
        ) ? $this->queries['controller'] : Controller::DEFAULT_CONTROLLER;

        return $this->_runActionController($this->_controllerName);
    }

    protected function _runActionController($controllerName)
    {
        $actionControllerName = ucfirst($controllerName) . 'Controller';

        include(Controller::CONTROLLERS_DIR . $actionControllerName . '.php');
        $this->_actionController = new $actionControllerName($this);

        return $this->_actionController;        
    }
}
