<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Trust extends AbstractHelper
{
    public function __construct(\Zend\ServiceManager\ServiceManager $sm)
    {
        $this->sm = $sm;
    }

    public function __invoke()
    {
        $likeTable = $this->sm->get('like_table');
        $userId = $likeTable->getUserIdWithMaxLikeCount();

        if ($userId) {
            $user = $this->sm->get('users_table')->getUserById($userId); // todo
        }
        
        $markTrust = new TrustEntity();
        $markTrust->type = 'mark-trust';
        $markTrust->count = 1244345;
        $markTrust->src = '/img/810x380_marka.jpg';

        $peopleTrust = new TrustEntity();
        $peopleTrust->type = 'people-trust';
        $peopleTrust->count = 5423321;
        $peopleTrust->src = '/img/guinardorigem.jpg';

        $rand = rand(0, 1);

        return $rand ? $markTrust : $peopleTrust;
    }

}

class TrustEntity
{
    public $type;
    public $count;
    public $src;

}