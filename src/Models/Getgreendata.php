<?php

namespace App\Models;

use App\Helpers\Database;
use App\Helpers\Logger;
use Exception;

/**
 * Class Getgreendata
 * @package App\Models
 */
class Getgreendata extends AbstractModel
{
    public $cmp;
 

    /**
     * Getgreendata constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function getcmp($userid)
    {
        if(isset($userid)){
        $sql = "SELECT cmp as 'cmp' FROM  recyc_customer_links_to_company AS u
        JOIN recyc_company_sync AS s ON
        s.company_id = u.company_id
        WHERE user_id = :user";
        $result = $this->rdb->prepare($sql);
        
        try{
        $result->execute(array(':user' => $userid));
        $this->cmp = $result->fetch(\PDO::FETCH_OBJ);
        return $this->cmp;
        }catch(Exception $e){
            Logger::getInstance("cmpnumbers.log")->warning(
                'confirmlist',
                [
                    'line' => $e->getLine(),
                    'error' => $e->getMessage()
                ]
            );
        }
    }

        
    }
}
