<?

class View
{
    public $data = array();
    public $viewFileName = 'index/index.phtml';
    public $layoutFileName = 'layout.phtml';

    public $showLayout = true;
    public $showView = true;
    
    //TODO Config Class
    public $viewsPath = 'views';
    public $layoutsPath = 'layouts';

    public function __construct($controllerName = null, $actionName = null,
        $params = array()
    )
    {
        if (!is_null($controllerName)) {
            $this->viewFileName = $controllerName
                . '/' . (is_null($actionName)
                    ? ActionController::_DEFAULT_ACTION
                    : $actionName
                )
                . '.phtml';
        }

        $this->data = $params;    
    }

    public function render()
    {

        $fileContent = $this->showLayout
            ? file_get_contents(APPLICATION_PATH . $this->layoutsPath . '/'
                . $this->layoutFileName
            ) : '';

        if ($this->showView) {
            extract($this->data);

            ob_start();
            include(APPLICATION_PATH . $this->viewsPath . '/'
                . $this->viewFileName
            );
            $viewContent = ob_get_contents();
            ob_end_clean();
        } else {
            $viewContent = '';
        }

        echo str_replace('{content}', $viewContent, $fileContent);
    }
}
