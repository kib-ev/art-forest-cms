<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getServiceManager()->get('viewhelpermanager')->setFactory('controllerName', function($sm) use ($e) {
            $viewHelper = new View\Helper\ControllerName($e->getRouteMatch());
            return $viewHelper;
        });

        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $this->setDefaultTranslator($e);
    }

    // translate validation messages 
    // Application/config/module.config.php must be setted locale ru_RU
    protected function setDefaultTranslator($e)
    {
        $translator = $e->getApplication()->getServiceManager()->get('translator');

        $type = 'phpArray';
        $filename = 'data/language/ru/Zend_Validate.php';
        $textDomain = 'default';
        $locale = 'ru_RU';

        $translator->addTranslationFile($type, $filename, $textDomain, $locale);

        \Zend\Validator\AbstractValidator::setDefaultTranslator($translator);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                // the array key here is the name you will call the view helper by in your view scripts
                'getServiceManager' => function($vhm) {
                    $sm = $vhm->getServiceLocator(); // $vhm is the view helper manager, so we need to fetch the main service manager
                    return new \Application\View\Helper\ServiceManager($sm);
                },
                'thumb' => function($vhm) {
                    $sm = $vhm->getServiceLocator(); // $vhm is the view helper manager, so we need to fetch the main service manager
                    return new \Application\View\Helper\Thumb($sm);
                },
                'getTrustEntity' => function($vhm) {
                    $sm = $vhm->getServiceLocator(); // $vhm is the view helper manager, so we need to fetch the main service manager
                    return new \Application\View\Helper\Trust($sm);
                },
            ),
        );
    }

}