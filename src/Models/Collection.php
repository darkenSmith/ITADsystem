<?php

namespace App\Models;

use App\Helpers\Database;

/**
 * Class Collection
 * @package App\Models
 */
class Collection extends AbstractModel
{

    public $collections;
    public $heading;

    /**
     * Collection constructor.
     */
    public function __construct()
    {
        $this->rdb = Database::getInstance('recycling');
        $this->ldb = Database::getInstance('legacy');
        $this->heading = 'Collections';

        parent::__construct();
    }

    public function getCollections()
    {
        $sql = 'SELECT
					Request_ID,
					date(Request_date_added),
					Request_Customer_contact,
					Request_Customer_email,
					Request_Customer_contact,
					Request_Customer_phone,
					Request_Customer_name,
					Request_town,
					Request_county,
					Request_postcode,
					Request_total_weight,
					Request_TotalUnits
				FROM
					`recyc_collection_requests`
				WHERE
				Request_is_done = 0
				and Request_deleted = 0';
        $result = $this->rdb->prepare($sql);
        $result->execute();
        $this->collections = $result->fetchAll(\PDO::FETCH_OBJ);
    }

    public function saveCollection()
    {
        foreach ($_POST as $key => $value) {
            $values[strtolower(str_replace('_', '', $key))] = stripslashes($value);
            echo ':' . strtolower(str_replace('_', '', $key)) . '<br>';
        }
        $lastSql = 'SELECT TOP 1 Request_ID FROM [dbo].[Request] order by ID desc';
        $result = $this->ldb->prepare($lastSql);
        $result->execute();
        $last = $result->fetch(\PDO::FETCH_COLUMN);
        $last++;
        $values['requestId'] = $last;

        $sql = 'INSERT INTO Request ("Request_ID","Request_date_added","Request_Coll_date","Request_coll_instructions","Request_PC_NW_QTY","Request_PC_W_QTY","Request_PC_ASSET_REQ","Request_PC_WIPE_REQ","Request_LAPTOP_NW_QTY","Request_LAPTOP_W_QTY","Request_LAPTOP_ASSET_REQ","Request_LAPTOP_WIPE_REQ","Request_SERVER_NW_QTY","Request_SERVER_W_QTY","Request_SERVER_ASSET_REQ","Request_SERVER_WIPE_REQ","Request_PRO_NW_QTY","Request_PRO_W_QTY","Request_TFT_NW_QTY","Request_TFT_W_QTY","Request_TFT_ASSET_REQ","Request_CRT_NW_QTY","Request_CRT_W_QTY","Request_TV_NW_QTY","Request_TV_W_QTY","Request_TV_ASSET_REQ","Request_BOARD_NW_QTY","Request_BOARD_W_QTY","Request_BOARD_ASSET_REQ","Request_OTHER1","Request_OTHER1_NW_QTY","Request_OTHER1_W_QTY","Request_OTHER2","Request_OTHER2_NW_QTY","Request_OTHER2_W_QTY","Request_OTHER3","Request_OTHER3_NW_QTY","Request_OTHER3_W_QTY","Request_contact_name","Request_contact_tel","Request_address1","Request_address2","Request_address3","Request_town","Request_county","Request_postcode","Request_premises_code","Request_premises_exempt","Request_Customer_name","Request_Customer_contact","Request_Customer_email","Request_Customer_phone","Request_Customer_contact_position","Request_Bios_password","Request_is_collection","Request_collection_date","Request_deleted","Request_is_done","Request_is_done_date","Request_total_weight","Request_BOARD_Wipe_Req","Request_DESKTOPPRINTER_W_QTY","Request_DESKTOPPRINTER_NW_QTY","Request_STANDALONEPRINTER_W_QTY","Request_STANDALONEPRINTER_NW_QTY","Request_DeleteNote","Request_DeleteDate","Request_UpdateNote","Request_DeletedBy","Request_UpdatedBy","Request_SMARTBOARD_ASSET_REQ","Request_SMARTBOARD_WIPE_REQ","Request_SMARTBOARD_NW_QTY","Request_SMARTBOARD_W_QTY","Request_ALLINONEPC_NW_QTY","Request_ALLINONEPC_W_QTY","Request_ALLINONEPC_ASSET_REQ","Request_ALLINONEPC_WIPE_REQ","Request_TotalUnits") 
				VALUES (:org,:contactemail,:contactphone,:address1,:address2,:address3,:town,:county,:postcode,:sitecontact,:sitephone,:premisescode,:premisesexempt,:colldates,:collnotes,:pcwqty,:pcnwqty,:pcwage,:pcnwage,:laptopwqty,:laptopnwqty,:laptopwage,:laptopnwage,:srvwqty,:srvnwqty,:wbwqty,:wbnwqty,:sbwqty,:sbnwqty,:aiopcwqty,:aiopcnwqty,:tvwqty,:tvnwqty,:tftwqty,:tftnwqty,:crtwqty,:crtnwqty,:prowqty,:pronwqty,:deskprnwqty,:deskprnnwqty,:floorprnwqty,:floorprnnwqty,:other1,:other1wqty,:other1nwqty,:other2,:other2wqty,:other2nwqty,:other3,:other3wqty,:other3nwqty,:biospassword,:position,:confirmed)';
        $result = $this->ldb->prepare($sql);
    }
}
