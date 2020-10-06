<?php

namespace App\Models;

use App\Helpers\Database;

/**
 * Class Order
 * @package App\Models
 */
class Order extends AbstractModel
{
    public $detail;
    public $files;
    public $id;
    public $lineItems;
    public $newFiles;

    /**
     * Order constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function loadById($id)
    {
        $this->id = $id;
        $sql = 'SELECT * FROM `recyc_order_information` WHERE id = :id';
        $result = $this->rdb->prepare($sql);
        $result->execute(array(':id' => $id));
        $this->detail = $result->fetch(\PDO::FETCH_OBJ);

        $file = $_SERVER["DOCUMENT_ROOT"] . "/RS_Files/datafromdet.txt";
        if (is_writable($file)) {
            $fh = fopen($file, 'a+');
            fwrite($fh, print_r($this->detail, true) . "\n");
            fclose($fh);
        }

        $files = array(
            'asset' => 'Asset-Management-Report.pdf',
            'disposal' => 'Certificate-of-Disposal.pdf',
            'rebate' => 'Rebate-Report.pdf'
        );

        //loop through, add to collection
        foreach ($files as $dir => $file) {
            // $_SERVER["DOCUMENT_ROOT"]."/RS_Files/
            $path = '/uploads/' . $dir . '/';

            $filename = $this->detail->sales_order_number . '-' . $file;
            $altFilename = $this->detail->sales_order_number . '-' . str_replace('-', ' ', $file);
            if (file_exists($path . $filename)) {
                $this->files[$dir] = $filename;
            } elseif (file_exists($path . $altFilename)) {
                $this->files[$dir] = $altFilename;
            }
        }

        $sql = 'SELECT * FROM recyc_uploads WHERE order_id = :id and downloadable = 1';
        $result = $this->rdb->prepare($sql);
        $result->execute(array(':id' => $id));
        $newFiles = $result->fetchAll(\PDO::FETCH_OBJ);

        $file = $_SERVER["DOCUMENT_ROOT"] . "/RS_Files/custfilesdetial.txt";
        if (is_writable($file)) {
            $fh = fopen($file, 'a+');
            fwrite($fh, print_r($newFiles, true) . "\n");
            fclose($fh);
        }

        if ($newFiles) {
            $this->newFiles = $newFiles;
        }

        $sql = 'SELECT product_name, count(product_name) as count FROM `recyc_sales_order_detail` WHERE `sales_order_number` = :order GROUP BY product_name';
        $result = $this->rdb->prepare($sql);
        $result->execute(array(':order' => $this->detail->sales_order_number));
        $this->lineItems = $result->fetchAll(\PDO::FETCH_OBJ);
    }
}
