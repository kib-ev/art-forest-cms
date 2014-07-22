<?php

/**
 * CsnUser - Coolcsn Zend Framework 2 User Module
 * 
 * @link https://github.com/coolcsn/CsnUser for the canonical source repository
 * @copyright Copyright (c) 2005-2013 LightSoft 2005 Ltd. Bulgaria
 * @license https://github.com/coolcsn/CsnUser/blob/master/LICENSE BSDLicense
 * @author Stoyan Cheresharov <stoyan@coolcsn.com>
 * @author Svetoslav Chonkov <svetoslav.chonkov@gmail.com>
 * @author Nikola Vasilev <niko7vasilev@gmail.com>
 * @author Stoyan Revov <st.revov@gmail.com>
 * @author Martin Briglia <martin@mgscreativa.com>
 */

namespace Search\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{
    protected $dbTable;
    
    protected $fields;

    public function setDbTable($dbTable)
    {
        $this->dbTable = $dbTable;

        return $this->dbTable;
    }

    public function getDbTable()
    {
        return $this->dbTable;
    }
    
     public function setFields($fields)
    {
        $this->fields = $fields;

        return $this->fields;
    }

    public function getFields()
    {
        return $this->fields;
    }


}