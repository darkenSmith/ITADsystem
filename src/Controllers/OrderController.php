<?php

namespace App\Controllers;

use App\Helpers\App;
use App\Models\Company;
use App\Models\Order;

/**
 * Class OrderController
 * @package App\Controllers
 */
class OrderController extends AbstractController
{

    public function view()
    {

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        } else {
            $id = date('id');
        }

        $app    = new App();
        $order  = new Order();
        $order->loadById($id);

        $this->template->view(
            'order/details',
            [
              'order' => $order
            ]
        );
        require_once(TEMPLATE_DIR . 'order/details.php');
    }


    public function download()
    {
        if (isset($_GET['file'])) {
          //@todo security check to match file belongs to logged in user
            $filename = base64_decode($_GET['file']);
            $userFile = explode('/', $filename);
            $userFile = $userFile[1];

            $filepath = '/uploads/'. $filename;

            if (file_exists($filepath)) {
                $data = file_get_contents($filepath);
                header("Cache-Control: public");
                header("Content-Description: File Transfer");
                header("Content-Disposition: attachment; filename=$userFile");
                header("Content-Type: application/pdf");
                header('Content-Length: ' . filesize($filepath));
                header("Content-Transfer-Encoding: binary");
                echo $data;
            }
        }

        if (isset($_GET['newfile'])) {
          //@todo security check to match file belongs to logged in user
            $filename_original = $_GET['newfile'];

            $filename = base64_decode($filename_original);

          // Change tag: getFileFormat
            if (isset($_GET["format"])) {
                $format = base64_decode($_GET["format"]);
            } else {
                $format = "application/pdf";
            }

          // Change tag: addExtension
            if ($format == "application/pdf") {
                $extension = ".pdf";
            } else {
                if ($format == "application/vnd.ms-excel") {
                    $extension = ".xls";
                } elseif ($format == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
                    $extension = ".xlsx";
                } elseif ($format == "image/tiff") {
                    $extension = ".tif";
                } elseif ($format == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
                    $extension = ".docx";
                } else {
                    $extension = ".pdf";
                }
            }

            $userFile = explode('+', $filename);

          // Change tag: addExtension
            $userFile = str_replace(' ', '-', $userFile[3]).$extension; //'.pdf';

          // Change tag: serverPath
            if (php_uname("n") == "MIS-17") {
                $filepath = $_SERVER["DOCUMENT_ROOT"]."/uploads/". $filename_original.".pdf";
            } else {
                $filepath = '/uploads/'. $filename_original.'.pdf';
            }

            if (file_exists($filepath)) {
                $data = file_get_contents($filepath);

                header("Cache-Control: public");
                header("Content-Description: File Transfer");
                header("Content-Type: ".$format);
                header('Content-Disposition: attachment; filename="'.$userFile.'"');
                header("Content-Transfer-Encoding: binary");
                header('Content-Length: '.filesize($filepath));
              // Change tag: cleanOutput
                ob_get_clean();
                readfile($filepath);
              // echo $data;
            }
        }
    }
}
