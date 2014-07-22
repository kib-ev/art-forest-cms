<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

class ControllerName extends AbstractHelper
{
    protected $routeMatch;

    public function __construct($routeMatch)
    {
        $this->routeMatch = $routeMatch;
    }

    public function __invoke()
    {
        if ($this->routeMatch) {
            $controllerParam = $this->routeMatch->getParam('controller');
            $action = $this->routeMatch->getParam('action');
            list($module,, $controller) = explode(DIRECTORY_SEPARATOR, $controllerParam);

            $moduleName = 'module-' . strtolower($module);
            $controllerName = 'controller-' . strtolower($controller);
            $actionName = 'action-' . strtolower($action);

            return $moduleName . ' ' . $controllerName . ' ' . $actionName;
        }
    }

}
