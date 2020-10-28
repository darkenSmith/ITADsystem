<?php
namespace App\Models\Conf;

use App\Helpers\Database;
use App\Helpers\Logger;
use App\Models\AbstractModel;

/**
 * Class Confirm
 * @package App\Models\Conf
 */
class Confirm extends AbstractModel
{
    /**
     * Confirm constructor.
     */
    public function __construct()
    {
        $this->sdb = Database::getInstance('sql01');
        parent::__construct();
    }

    /**
     * @param $reqid
     * @return bool
     */
    public function confirmList($reqid)
    {
        if (!empty($reqid)) {
            $sql = "UPDATE
                  Booked_Collections
                SET
                ConfirmEmailSent = :ConfirmEmailSent
                booking_status = :booking_status
                WHERE
                  RequestID = :RequestID
                  update request
                set confirmed = :confirmed,
                laststatus = :laststatus
                where Request_ID = :Request_ID";

            try {
                $stmt = $this->sdb->prepare($sql);
                return $stmt->execute([
                   ':ConfirmEmailSent' => 'Yes',
                   ':booking_status' => 'confirmed',
                   ':RequestID' => $reqid,
                   ':confirmed' => 1,
                   ':laststatus' => 'Confirmed',
                   ':Request_ID' => $reqid,
                ]);
            } catch (\Exception $e) {
                Logger::getInstance("Confirm.log")->warning(
                    'confirmlist',
                    [
                        'line' => $e->getLine(),
                        'error' => $e->getMessage()
                    ]
                );
            }
        }

        return false;
    }
}
