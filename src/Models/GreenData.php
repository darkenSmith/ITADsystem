<?php

namespace App\Models;

use App\Helpers\Logger;
use Exception;

/**
 * Class GreenData
 * @package App\Models
 */
class GreenData extends AbstractModel
{
    public $cmp;

    /**
     * GreenData constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function getCmp($userId)
    {
        if (isset($userId)) {
            $sql = "SELECT cmp FROM recyc_customer_links_to_company AS u
            JOIN recyc_company_sync AS s ON
            s.company_id = u.company_id
            WHERE user_id = :user";

            try {
                $result = $this->rdb->prepare($sql);
                $result->execute(array(':user' => $userId));
                $this->cmp = $result->fetch(\PDO::FETCH_OBJ);
                return $this->cmp;
            } catch (Exception $e) {
                Logger::getInstance("GreenData.log")->warning(
                    'getCmp',
                    [
                        'line' => $e->getLine(),
                        'error' => $e->getMessage()
                    ]
                );
            }
        }

        return null;
    }
}
