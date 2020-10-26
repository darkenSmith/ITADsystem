<?php
namespace App\Models;

use App\Helpers\Config;
use App\Helpers\Logger;

class Register extends AbstractModel
{
    /**
     * Register constructor.
     */
    public function __construct()
    {
        $this->emailConfig = Config::getInstance()->get('email');

        parent::__construct();
    }

    public function register()
    {
        /**
         * @todo form submited
         */

        return ['success' => true];
    }
}
