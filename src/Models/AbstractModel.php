<?php

namespace App\Models;

use App\Helpers\Database;

/**
 * Class ModelAbstract
 * @package App\Models
 */
abstract class AbstractModel
{
    public $rdb;
    public $ldb;
    public $sdb;
    public $gdb;

    /**
     * AbstractModel constructor.
     */
    public function __construct()
    {
        $this->rdb = Database::getInstance('recycling');
    }
}
