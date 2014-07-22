<?php

namespace Banners\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Banners\Model\Banner;

class BannerHelper extends AbstractHelper
{
    protected $sm;

    public function __construct(\Zend\ServiceManager\ServiceManager $sm)
    {
        $this->sm = $sm;
    }

    public function __invoke($type)
    {
        return $this->getView()->partial('banners/helper/simple', array(
            'type' => $type,
        ));
    }

}