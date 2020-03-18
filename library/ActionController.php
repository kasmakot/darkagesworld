<?

class ActionController
{
    const _DEFAULT_ACTION = 'index';

    protected $_baseController = null;
    public $actionName = 'index';
    public $view = null;

    public function __construct($baseController = null)
    {
        $this->_baseController = $this->_loadBaseController($baseController);

        if (!is_null($actionName = $this->getParam('action'))
            && $this->isActionExists($actionName)
        ) {
            $this->actionName = $actionName;
        }

        $this->view = new View(
            $this->getControllerName(),
            $this->actionName,
            $this->getAllParams()
        );
        $this->init();

        return call_user_func_array(
            array($this, ucfirst($this->actionName) . 'Action'), array()
        );
    }

    public function __destruct()
    {
        $this->view->render();
    }

    public function isActionExists($actionName)
    {
        return method_exists($this, ucfirst($actionName) . 'Action');
    }
    
    public function init()
    {
    }

    public function IndexAction()
    {
        print 'Default IndexAction';
    }

    public function getParam($paramName)
    {
        return (
            (!is_null($this->_baseController)
                && array_key_exists($paramName, $this->_baseController->queries)
            ) ? $this->_baseController->queries[$paramName] : null
        );
    }

    public function getAllParams()
    {
        return (!is_null($this->_baseController)
            ? $this->_baseController->queries : array()
        );
    }

    public function getControllerName()
    {
        return (!is_null($this->_baseController)
            ? $this->_baseController->getControllerName()
            : BaseController::_DEFAULT_CONTROLLER
        );
    }

    public function getConfigData()
    {
        return (!is_null($this->_baseController)
            ? $this->_baseController->configData
            : array()
        );
    }

    protected function _loadBaseController($baseController = null)
    {
        if (!is_null($baseController)) {
            return $baseController;
        } else {
            // TODO new object of BaseController
            return null;
        }
    }
}
