<?php

namespace Users\Model;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity 
 * @ORM\Table(name="users")
 */
class User
{
    const STATE_NOT_ACTIVATED = 'not_activated';
    const STATE_ACTIVATED = 'activated';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    public $user_id;

    /** @ORM\Column(type="text", nullable=true) */
    public $username;

    /** @ORM\Column(type="text", nullable=true) */
    public $display_name;

    /** @ORM\Column(type="text") */
    public $email;

    /** @ORM\Column(type="text") */
    public $password;

    /** @ORM\Column(type="text", nullable=true) */
    public $clear_password;

    /** @ORM\Column(type="text", nullable=true) */
    public $state;

    /** @ORM\Column(type="datetime", nullable=true) */
    public $create_date;

    /** @ORM\Column(type="datetime", nullable=true) */
    public $off_date;

    /*     * ***************************************** */

    /** @ORM\Column(type="text", nullable=true) */
    public $reg_type;

    /** @ORM\Column(type="text", nullable=true) */
    public $org_name;

    /** @ORM\Column(type="text", nullable=true) */
    public $position;

    /** @ORM\Column(type="text", nullable=true) */
    public $last_name;

    /** @ORM\Column(type="text", nullable=true) */
    public $first_name;

    /** @ORM\Column(type="text", nullable=true) */
    public $middle_name;

    /** @ORM\Column(type="text", nullable=true) */
    public $country;

    /** @ORM\Column(type="text", nullable=true) */
    public $city;

    /** @ORM\Column(type="text", nullable=true) */
    public $region;

    /** @ORM\Column(type="text", nullable=true) */
    public $zip;

    /** @ORM\Column(type="text", nullable=true) */
    public $street;

    /** @ORM\Column(type="text", nullable=true) */
    public $house;

    /** @ORM\Column(type="text", nullable=true) */
    public $office;

    /** @ORM\Column(type="text", nullable=true) */
    public $phone;

    /** @ORM\Column(type="text", nullable=true) */
    public $unp;

    /** @ORM\Column(type="text", nullable=true) */
    public $egr_org;

    /** @ORM\Column(type="text", nullable=true) */
    public $egr_num;

    /** @ORM\Column(type="text", nullable=true) */
    public $egr_date;

    /** @ORM\Column(type="text", nullable=true) */
    public $bank;

    /** @ORM\Column(type="text", nullable=true) */
    public $bank_code;

    /** @ORM\Column(type="text", nullable=true) */
    public $bank_address;

    /** @ORM\Column(type="text", nullable=true) */
    public $bank_acc;

    /** @ORM\Column(type="integer") */
    public $role_id;

    public function getRoleId()
    {
        return $this->role_id;
    }

    public function setRoleId($roleId)
    {
        $this->role_id = $roleId;
    }

    public function getDisplayName()
    {
        return $this->display_name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getId()
    {
        return $this->user_id;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getState()
    {
        return $this->state;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setDisplayName($displayName)
    {
        $this->display_name = $displayName;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setId($id)
    {
        $this->user_id = $id;
    }

    public function setPassword($clear_password)
    {
        $this->password = md5($clear_password);
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function exchangeArray($data)
    {
        $this->user_id = (isset($data['user_id'])) ? $data['user_id'] : NULL;
        $this->username = (isset($data['username'])) ? $data['username'] : NULL;
        $this->display_name = (isset($data['display_name'])) ? $data['display_name'] : NULL;
        $this->email = (isset($data['email'])) ? $data['email'] : NULL;
        $this->setPassword((isset($data['password'])) ? $data['password'] : NULL);
        $this->clear_password = (isset($data['clear_password'])) ? $data['clear_password'] : NULL;
        $this->state = (isset($data['state'])) ? $data['state'] : NULL;
        $this->create_date = (isset($data['create_date'])) ? $data['create_date'] : NULL;
        $this->off_date = (isset($data['off_date'])) ? $data['off_date'] : NULL;
        
        $this->reg_type = (isset($data['reg_type']) ? $data['reg_type'] : null);

        $this->org_name = (isset($data['org_name']) ? $data['org_name'] : null);
        $this->position = (isset($data['position']) ? $data['position'] : null);
        $this->last_name = (isset($data['last_name']) ? $data['last_name'] : null);
        $this->first_name = (isset($data['first_name']) ? $data['first_name'] : null);
        $this->middle_name = (isset($data['middle_name']) ? $data['middle_name'] : null);
        $this->country = (isset($data['country']) ? $data['country'] : null);
        $this->city = (isset($data['city']) ? $data['city'] : null);
        $this->region = (isset($data['region']) ? $data['region'] : null);
        $this->zip = (isset($data['zip']) ? $data['zip'] : null);
        $this->street = (isset($data['street']) ? $data['street'] : null);
        $this->house = (isset($data['house']) ? $data['house'] : null);
        $this->office = (isset($data['office']) ? $data['office'] : null);
        $this->phone = (isset($data['phone']) ? $data['phone'] : null);

        $this->unp = (isset($data['unp']) ? $data['unp'] : null);
        $this->egr_org = (isset($data['egr_org']) ? $data['egr_org'] : null);
        $this->egr_num = (isset($data['egr_num']) ? $data['egr_num'] : null);
        $this->egr_date = (isset($data['egr_date']) ? $data['egr_date'] : null);

        $this->bank = (isset($data['bank']) ? $data['bank'] : null);
        $this->bank_code = (isset($data['bank_code']) ? $data['bank_code'] : null);
        $this->bank_address = (isset($data['bank_address']) ? $data['bank_address'] : null);
        $this->bank_acc = (isset($data['bank_acc']) ? $data['bank_acc'] : null);
        $this->role_id = (isset($data['role_id'])) ? $data['role_id'] : NULL;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}