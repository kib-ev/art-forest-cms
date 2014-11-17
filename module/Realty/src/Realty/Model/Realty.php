<?php

namespace Realty\Model;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity 
 * @ORM\Table(name="realty")
 */
class Realty {

    const REALTY_ID = 'realty_id';
    const USER_ID = 'user_id';
    const TITLE = 'title';
    const CREATE_DATE = 'create_date';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $realty_id;

    /** @ORM\Column(type="integer") */
    protected $user_id;

    /** @ORM\Column(type="text", nullable=true) */
    protected $title;

    /** @ORM\Column(type="text", nullable=true) */
    protected $realty_type; //жилая, комм., дома

    /** @ORM\Column(type="text", nullable=true) */
    protected $contact_phone;

    /** @ORM\Column(type="text", nullable=true) */
    protected $contact_name;

    /** @ORM\Column(type="text", nullable=true) */
    protected $position_x;

    /** @ORM\Column(type="text", nullable=true) */
    protected $position_y;

    /** @ORM\Column(type="text", nullable=true) */
    protected $region; // область

    /** @ORM\Column(type="text", nullable=true) */
    protected $discrict; // район

    /** @ORM\Column(type="text", nullable=true) */
    protected $town; // нас. пункт

    /** @ORM\Column(type="text", nullable=true) */
    protected $street; // улица

    /** @ORM\Column(type="text", nullable=true) */
    protected $number_of_house; // дом, корпус

    /** @ORM\Column(type="text", nullable=true) */
    protected $apartment; // квартира, офис

    // FLAT ATTR *********************************

    /** @ORM\Column(type="text", nullable=true) */
    protected $type_of_flat;

    /** @ORM\Column(type="text", nullable=true) */
    protected $number_of_rooms;

    /** @ORM\Column(type="text", nullable=true) */
    protected $floor;

    /** @ORM\Column(type="text", nullable=true) */
    protected $floor_in_the_house;

    /** @ORM\Column(type="text", nullable=true) */
    protected $type_of_house; // монолитный, панельный...

    /** @ORM\Column(type="text", nullable=true) */
    protected $total_area;

    /** @ORM\Column(type="text", nullable=true) */
    protected $residental_area;

    /** @ORM\Column(type="text", nullable=true) */
    protected $kitchen_area;

    /** @ORM\Column(type="text", nullable=true) */
    protected $type_of_wc;

    /** @ORM\Column(type="text", nullable=true) */
    protected $type_of_flooring;

    /** @ORM\Column(type="text", nullable=true) */
    protected $type_of_balcony;

    /** @ORM\Column(type="text", nullable=true) */
    protected $type_of_planning;

    /** @ORM\Column(type="text", nullable=true) */
    protected $type_of_repair;

    /** @ORM\Column(type="text", nullable=true) */
    protected $year_built;

    /** @ORM\Column(type="text", nullable=true) */
    protected $year_overhaul;


    // ******** *********************************

    /**
     * @ORM\Column(type="text", nullable=true) 
     */
    protected $create_date;

    /**
     * @ORM\Column(type="text", nullable=true) 
     */
    protected $last_update_time;

    public function __construct($data = null) {
        if ($data) {
            $this->exchangeArray($data);
        }
    }

    public function exchangeArray($data) {
        $vars = $this->getArrayCopy();
        for ($i = 0; $i < count($vars); $i++) {
            $varName = key($vars);
            $this->$varName = (isset($data[$varName])) ? $data[$varName] : $this->$varName;
            next($vars);
        }
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

    public function get($varName) {
        $vars = $this->getArrayCopy();
        return $vars[$varName];
    }

}
