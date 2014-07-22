<?php

namespace Users\View\Helper;

use Zend\View\Helper\AbstractHelper;

class UserHelper extends AbstractHelper
{
    protected $user;

    public function __construct(\Users\Model\User $user)
    {
        $this->user = $user;
    }

    public function getLoggedInUser()
    {
        return $this->user;
    }

    public function isUserLoggedIn()
    {
        $email = $this->user->getEmail();
        return isset($email) ? true : false;
    }

}