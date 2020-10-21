<?php

namespace App\Models;

use App\Helpers\Database;

/**
 * Class Company
 * @package App\Models
 */
class Company extends AbstractModel
{
    public $userId;
    public $companies;
    public $unallocated;
    public $auth = true;
    public $customers;

    /**
     * Company constructor.
     */
    public function __construct()
    {
        if (isset($_SESSION['user']['id'])) {
            $this->userId = $_SESSION['user']['id'];
            $this->userRole = $_SESSION['user']['role_id'];
        } else {
            $this->userId = 61;
            $this->userRole = 1;
        }

        parent::__construct();
    }

    public function getCompany()
    {
        $sql = 'SELECT company_id from recyc_customer_links_to_company where user_id = :user';
        $result = $this->rdb->prepare($sql);
        $result->execute(array(':user' => $this->userId));
        $this->companies = $result->fetchAll(\PDO::FETCH_OBJ);

        if ($this->companies) {
            foreach ($this->companies as $company) {
                $data = $this->loadById($company->company_id);
                foreach ($data as $key => $value) {
                    $company->{$key} = $value;
                }
                $this->checkFiles($company->collections);
            }
        }
        unset($this->rdb);
    }

    public function loadById($id, $return = false)
    {
        $results = new \stdClass();

        if ($_SESSION['user']['role_id'] == 1 || $_SESSION['user']['role_id'] == 2) {
            $sql = 'SELECT cl.* FROM recyc_company_list cl
						left join recyc_bdm_to_company bc on cl.id = bc.company_id 
						WHERE id = :company and user_id = :user';
        } elseif ($_SESSION['user']['role_id'] == 3 || $_SESSION['user']['role_id'] == 4) {
            $sql = 'SELECT * FROM recyc_company_list cl
						LEFT JOIN recyc_customer_links_to_company c on cl.id = c.company_id 
						WHERE c.company_id = :company 
						and user_id = :user';
        } else {
            return 'Not Authorised';
        }

        $result = $this->rdb->prepare($sql);
        $result->execute(array(':company' => $id, ':user' => $_SESSION['user']['id']));
        $results->data = $result->fetch(\PDO::FETCH_OBJ);

        if ($results->data) {
            $results->summary = $this->getSummary($id);
            $results->collections = $this->getCollections($id);

            if ($return) {
                foreach ($results as $key => $value) {
                    $this->{$key} = $value;
                }
                $this->checkFiles($this->collections);
            } else {
                return $results;
            }
        } else {
            $this->auth = false;
        }
    }

    public function getCustomers()
    {
        $sql = 'SELECT * from recyc_company_list cl
				left join recyc_bdm_to_company bc on cl.id = bc.company_id 
				where user_id = :user';
        $result = $this->rdb->prepare($sql);
        $result->execute(array(':user' => $this->userId));
        $this->customers = $result->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getUnallocated()
    {
        $sql = 'SELECT * from recyc_company_list cl
				left join recyc_bdm_to_company bc on cl.id = bc.company_id
				where (user_id = "" OR user_id IS NULL) 
				and portal_requirement = 1';
        $result = $this->rdb->prepare($sql);
        $result->execute(array(':user' => $this->userId));
        $this->unallocated = $result->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getSummary($id)
    {
        $sql = 'select location_name, address1,address2,address3,address4, postcode,
				telephone,count(location_id) as "collections" 
				from recyc_order_information where company_id = :company 
				GROUP BY location_id';
        $result = $this->rdb->prepare($sql);
        $result->execute(array(':company' => $id));
        $data = $result->fetchAll(\PDO::FETCH_OBJ);
        return $data;
    }

    public function getCollections($id)
    {
        $sql = 'SELECT * FROM `recyc_order_information` WHERE `company_id` = :company ORDER BY actual_delivery_date desc';
        $result = $this->rdb->prepare($sql);
        $result->execute(array(':company' => $id));
        $data = $result->fetchAll(\PDO::FETCH_OBJ);

        return $data;
    }


    public function checkFiles($collections)
    {
        foreach ($collections as $collection) {
            $files = array(
                'asset' => 'Asset-Management-Report.pdf',
                'disposal' => 'Certificate-of-Disposal.pdf',
                'rebate' => 'Rebate-Report.pdf'
            );
            //loop through, add to collection
            foreach ($files as $dir => $file) {
                $path = PROJECT_DIR . 'uploads/' . $dir . '/';
                $filename = $collection->sales_order_number . '-' . $file;
                $altFilename = $collection->sales_order_number . '-' . str_replace('-', ' ', $file);
                if (file_exists($path . $filename)) {
                    $collection->files[$dir] = $collection->sales_order_number . $file;
                } elseif (file_exists($path . $altFilename)) {
                    $collection->files[$dir] = $altFilename;
                }
            }
            $sql = 'SELECT * FROM recyc_uploads WHERE order_id = :id and downloadable = 1';
            $result = $this->rdb->prepare($sql);
            $result->execute(array(':id' => $collection->id));
            $newFiles = $result->fetchAll(\PDO::FETCH_OBJ);

            foreach ($newFiles as $newFile) {
                if ($newFile->file_type == 'Asset Management Report') {
                    $dir = 'asset';
                } elseif ($newFile->file_type == 'Rebate Report') {
                    $dir = 'rebate';
                } elseif ($newFile->file_type == 'Certificate of Disposal') {
                    $dir = 'disposal';
                } else {
                    continue;
                }
                $collection->files[$dir] = $newFile->filename;
            }
            $e = 123;
        }
    }
}
