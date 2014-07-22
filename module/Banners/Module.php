<?php

namespace Banners;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
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
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'banners_table_gateway' => function ($sm) {
                    $adapter = $sm->get('zend_db_adapter');
                    $resultSetPrototype = new ResultSet();
                    $banner = new \Banners\Model\Banner();
                    $resultSetPrototype->setArrayObjectPrototype($banner);
                    $bannersTableGateway = 
                        new TableGateway('banners', $adapter, null, $resultSetPrototype);
                    return $bannersTableGateway;
                },
                'banners_table' => function ($sm) {
                    $bannersTableGateway = $sm->get('banners_table_gateway');
                    $bannersTable = new \Banners\Model\BannersTable($bannersTableGateway); 
                    return $bannersTable;
                },       
            ),
        );
    }
    
    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                // the array key here is the name you will call the view helper by in your view scripts
                'bannerHelper' => function($vhm) {
                    $sm = $vhm->getServiceLocator(); // $vhm is the view helper manager, so we need to fetch the main service manager
                    return new \Banners\View\Helper\BannerHelper($sm);
                },
            ),
        );
    }
}
