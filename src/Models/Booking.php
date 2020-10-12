<?php

namespace App\Models;

use App\Helpers\Config;
use App\Helpers\Database;
use App\Helpers\Logger;

class Booking extends AbstractModel
{
    public const BOOKING_FOLDER = 'booking/';
    public const UPLOAD_FOLDER = 'uploads/';
    private $emailConfig;
    private $emailReceiver = 'bulent.kocaman@stonegroup.co.uk'; // 'stoneITAD@stonegroup.co.uk';

    /**
     * Collection constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->emailConfig = Config::getInstance()->get('email');

        $this->sdb = Database::getInstance('sql01');
    }

    public function updateTables()
    {
        $sql = "select max(request_id)+ 1 as id from request;";

        $stmt = $this->sdb->query($sql);
        $d = $stmt->fetch(\PDO::FETCH_ASSOC);
        $_SESSION['req'] = $d['id'];
        $requestid = $d['id'];

        $next = 0;

        $cust_name = $_POST['org'];
        $cust_email = $_POST['email'];
        $cust_tel = $_POST['tel'];
        $premisecode = $_POST['prem'];
        $add1 = $_POST['add1'];
        $add2 = $_POST['add2'];
        $add3 = $_POST['add3'];
        $town = $_POST['twn'];
        $postcode = $_POST['postcode'];
        $contact = $_POST['contact'];
        $contact_tel = $_POST['contactphne'];
        $coldatenote = $_POST['colldatenote'] ?? null;
        $colinstruct = $_POST['colinstruct'];
        $request_contact = $_POST['requstcon'];
        $position = $_POST['pos'];
        $sic = '00000';
        $country = $_POST['country'];
        $is_exempt = $_POST['is_exempt'];
        $biopass = $_POST['biopass'];
        $charge = $_POST['chargable'];
        $access = $_POST['access'];
        $avoid = $_POST['avoid'];
        $ground = $_POST['ground'];
        $lift = $_POST['lift'];
        $steps = $_POST['steps'];
        $parking = $_POST['parking'];
        $twoman = $_POST['twoman'];
        $onsite = $_POST['onsite'];

        $is_other = 0;

        if ($ground == 'yes') {
            $lift = '-';
        }

        Logger::getInstance("emaillog.log")->debug($cust_email . "-" . date("Y/m/d h:i:s"));

        $other1name = isset($_POST['other1name']) ? $_POST['other1name'] : "";
        $other2name = isset($_POST['other2name']) ? $_POST['other2name'] : "";
        $other3name = isset($_POST['other3name']) ? $_POST['other3name'] : "";

        $arr = json_decode(json_encode($_POST['json']), true);
        $arrfinal = json_decode($arr, true);

        Logger::getInstance("arraycompdetails.log")->debug(print_r($arrfinal, true));

        $timestamp = date('Y-m-d G:i:s');

        $cleanname = filter_var($this->cleanData($cust_name, "text"), FILTER_SANITIZE_STRING);
        $cleanemail = filter_var($cust_email, FILTER_SANITIZE_EMAIL);
        $cleanadd1 = filter_var($this->cleanData($add1, "text"), FILTER_SANITIZE_STRING);
        $cleanadd2 = filter_var($this->cleanData($add2, "text"), FILTER_SANITIZE_STRING);
        $cleanadd3 = filter_var($this->cleanData($add3, "text"), FILTER_SANITIZE_STRING);
        $cleancontact = filter_var($this->cleanData($contact, "text"), FILTER_SANITIZE_STRING);
        $cleancoldatenote = filter_var($this->cleanData($coldatenote, "text"), FILTER_SANITIZE_STRING);
        $cleancolinstruct = $this->cleanData($colinstruct, "text");
        $cleanrequest = filter_var($this->cleanData($request_contact, "text"), FILTER_SANITIZE_STRING);
        $other1nameclean = $this->cleanData($other1name, "text");
        $other2nameclean = $this->cleanData($other2name, "text");
        $other3nameclean = $this->cleanData($other3name, "text");
        $cleantown = $this->cleanData($town, "text");
        $cleanpostcode = filter_var($this->cleanData($postcode, "text"), FILTER_SANITIZE_STRING);
        $biopassclean = $this->cleanData($biopass, "text");
        $accessclean = filter_var($access, FILTER_SANITIZE_STRING);
        $avoidclean = filter_var($avoid, FILTER_SANITIZE_STRING);
        $groundclean = filter_var($ground, FILTER_SANITIZE_STRING);
        $liftclean = filter_var($lift, FILTER_SANITIZE_STRING);
        $stepsclean = filter_var($steps, FILTER_SANITIZE_STRING);
        $parkingclean = filter_var($parking, FILTER_SANITIZE_STRING);
        $twomanclean = filter_var($twoman, FILTER_SANITIZE_STRING);
        $onsiteclean = filter_var($onsite, FILTER_SANITIZE_STRING);
        $biocl = filter_var($biopass, FILTER_SANITIZE_STRING);

        if ($groundclean == 'yes') {
            $liftclean = '-';
        }

        $search = $cleanname . $cleanpostcode;

        $sql = "select max(request_id)+ 1 as id from request;";

        $stmt = $this->sdb->prepare($sql);
        $stmt->execute();
        $d = $stmt->fetch(\PDO::FETCH_ASSOC);

        $debug_txt = "Max ID :" . $requestid . "\n";
        $reqid = $d['id'];

        $_SESSION['rid'] = $requestid;

        $sqlup = "insert into request(customer_name, customer_email, customer_phone,
premise_code, premise_exempt, add1, add2, add3, town, postcode, contact_name, contact_tel, request_col_date, req_col_instrct, request_date_added, customer_contact, customer_contact_positon, bio_pass, SICcode, country, request_id, deleted, confirmed, done,  laststatus, GDPRconf, charge, area1, [Early Acess notes], Help_Onsite, [Parking Notes], lift, ground, steps, twoman, avoidtimes)

values('" . $cleanname . "', '" . $cleanemail . "', '" . $cust_tel . "', '" . $premisecode . "', '" . $is_exempt . "', '" . $cleanadd1 . "', '" . $cleanadd2 . "', '" . $cleanadd3 . "', '" . $cleantown . "', '" . $cleanpostcode . "', '" . $cleancontact . "',
'" . $contact_tel . "', '" . $cleancoldatenote . "', '" . $cleancolinstruct . "', '" . $timestamp . "', '" . $cleanrequest . "', '" . $position . "','" . $biocl . "','" . $sic . "', '" . $country . "', " . $_SESSION['rid'] . ", '0', '0', '0', 'Request', '1', " . $charge . ", 'Empty', '" . $accessclean . "', '" . $onsiteclean . "', '" . $parkingclean . "', '" . $liftclean . "', '" . $groundclean . "', '" . $stepsclean . "', '" . $twomanclean . "', '" . $avoidclean . "');
exec updatearea @rid = '" . $_SESSION['rid'] . "';";

        $log = date("Y/m/d") . "  " . $cleanname . " " . "\n\n" . $cleanemail . " " . "\n\n" . $cust_tel . " " . "\n\n" . "orginal ID:" . " " . $_SESSION['rid'] . "\r\n";
        Logger::getInstance("RequestLog.log")->debug($log);

        $debug_txt .= $sqlup . "\n\n";
        $sqlup2 = '';

        foreach ($arrfinal as $output) {
            $obj = array();

            array_push($obj, $output);
            $idobj = $obj[0]['id'];


            Logger::getInstance("val.log")->debug($idobj);
            Logger::getInstance("detail.log")->debug(print_r($output, true));
            Logger::getInstance("dd.log")->debug(print_r($obj[0]['id'], true));
            Logger::getInstance("tst.log")->debug($obj[0]['id']);

            $id = $obj[0]['id'];
            if ($id == 'de') {
                $id = 0;
            }

            Logger::getInstance("idstst.log")->debug($id);

            $data = [
                'req_id' => $_SESSION['rid'],
                'prod_id' => $id,
                'QTY' => $obj[0]['working'],
                'Asset_req' => $obj[0]['asset'],
                'Wipe' => $obj[0]['wipe'],
                'other1_name' => $other1nameclean,
                'other2_name' => $other2nameclean,
                'other3_name' => $other3nameclean,
            ];

            $sqlup2 = "insert into Req_Detail(req_id, prod_id, QTY, Asset_req, Wipe, other1_name, other2_name, other3_name)
  values(:req_id, :prod_id, :QTY, :Asset_req, :Wipe, :other1_name, :other2_name, :other3_name);";

            $stmtpart = $this->sdb->prepare($sqlup2);
            $stmtpart->execute($data);

            $sql_executed = $this->pdoDump($sqlup2, $data);
            Logger::getInstance("newdetaillist.log")->debug($sql_executed);

            $debug_txt = $sqlup . "\n\n";
            $query = $sqlup;
        }

        $stmtpart = $this->sdb->prepare($query);
        $next = 1;

        if ($next != 0) {
            $stmtpart->execute();
            $sqldup = " WITH cte AS (
  SELECT 
      prod_id, 
   req_id, 
      QTY,
      ROW_NUMBER() OVER (
          PARTITION BY 
    prod_id
          ORDER BY 
            req_id
      ) row_num
   FROM 
      Req_Detail where req_id = " . $_SESSION['rid'] . "
)
delete FROM cte
WHERE row_num > 1;";

            $cleandup = $this->sdb->prepare($sqldup)->execute();

            $email = new \SendGrid\Mail\Mail();
            $sendgridConfig = $this->emailConfig['sendgrid'];

            $fullpath = PROJECT_DIR . "assets/doc/ITADCOVID19terms.pdf";                            // Passing `true` enables exceptions
            try {
                $email->setFrom($sendgridConfig['from']['ITADSystem'], "ITAD System");
                $email->setSubject('New Request - Stone  ITAD  - ' . $_SESSION['rid']);
                $email->addTo($cust_email);

                $att1 = new \SendGrid\Mail\Attachment();
                $att1->setContent(file_get_contents($fullpath));
                $att1->setType("application/pdf");
                $att1->setFilename("ITADCOVID19terms.pdf");
                $att1->setDisposition("attachment");
                $email->addAttachment($att1);

                $content = file_get_contents(PROJECT_DIR . 'views/template/email/new-request.php');

                $email->addContent("text/html", $content);
                $sendgrid = new \SendGrid($sendgridConfig['api']['key']);
                $response = $sendgrid->send($email);

                if ($response->statusCode() !== 202) {
                    throw new \Exception($response->body());
                }

                echo 'Message has been sent';
            } catch (\Exception $e) {
                Logger::getInstance("Mailfailed.log")->warning('Mailfailed', [$e->getMessage()]);

                $this->sendFailedMailToRecycling();
            }

            $sqlcheck = 'select Request_id from request where Request_id = ' . $_SESSION['rid'];


            $runcheck = $this->sdb->prepare($sqlcheck);
            $runcheck->execute();

            if (!$runcheck) {
                $email = new \SendGrid\Mail\Mail();
                $sendgridConfig = $this->emailConfig['sendgrid'];
                try {
                    $email->setFrom($sendgridConfig['from']['ITADSystem'], "ITAD System");
                    $email->addTo($cust_email);
                    $email->setSubject('New Request ' . $_SESSION['rid']);

                    $content = file_get_contents(PROJECT_DIR . 'views/template/email/new-request-run-check.php');

                    $email->addContent("text/html", $content);
                    $sendgrid = new \SendGrid($sendgridConfig['api']['key']);
                    $response = $sendgrid->send($email);

                    if ($response->statusCode() !== 202) {
                        throw new \RuntimeException($response->body());
                    }
                } catch (\Exception $e) {
                    Logger::getInstance("Mailfailed.log")->warning('Mail Failed', [$e->getMessage()]);
                }
            }

            Logger::getInstance("rijigsql.log")->debug('sqlup', [$sqlup]);

            $_SESSION['custname'] = $cleanname;

            $this->toRecycling();
        }
    }

    public function cleanData($value, $type)
    {
        if ($type == "text") {
            $value = preg_replace("/[^a-zA-Z0-9\-\_\ go]/", "", $value);
            str_replace("'", "''''", $value);
        }
        if ($type == "email") {
            $value = preg_replace("/[^a-zA-Z0-9\.\-\@]/", "", $value);
        }
        if ($type == "date") {
            $value = preg_replace("/[^a-zA-Z0-9\-\.\@\\\/]/", "", $value);
        }
        if ($type == "password") {
            $value = preg_replace("/[\'\"\;]/", "", $value);
        }
        if ($type == "number") {
            $value = preg_replace("/![0-9]/", "", $value);
        }
        if ($type == "array") {
            $value = preg_replace("/[^a-zA-Z0-9\,]/", "", $value);
        }
        if ($type == "mac") {
            $value = preg_replace("/[^a-zA-Z0-9\,\:]/", "", $value);
        }
        strip_tags($value);
        return $value;
    }

    public function pdoDump($sql_string, $array_values)
    {
        if (is_array($array_values)) {
            foreach ($array_values as $key => $value) {
                $sql_string = str_replace($key, (is_int($value) ? $value : "'" . $value . "'"), $sql_string);
            }
        }

        return $sql_string;
    }

    public function sendFailedMailToRecycling()
    {
        Logger::getInstance("attachments.log")->debug('filestuff', $_SESSION['filestuff']);
        $sql = "select pl.Product,  rd.QTY, Asset_req, Wipe, other1_name, other2_name, other3_name, sum(round(pl.typicalweight, 2) * qty) as estweight  from Request_test2  as rt
join Req_Detail as rd on
rd.req_id = rt.Request_id
join productlist as pl with(nolock) on 
pl.product_ID = rd.prod_id
where Request_id =  " . $_SESSION['rid'] . "
group by pl.Product,  rd.QTY, Asset_req, Wipe, other1_name, other2_name, other3_name";
        $stmt = $this->sdb->prepare($sql);
        $stmt->execute();
        $d = $stmt->fetchall(\PDO::FETCH_ASSOC);

        $table = '<table class="table">
  <thead>
  <tr>
  <th>  Product </th>
  <th>  Qty </th>
  <th>  est. Weight </th>
  </tr>
  <thead>';

        foreach ($d as $obj) {
            $table .= '<tbody><tr>
    <td>' . $obj['Product'] . ' </td>
    <td>' . $obj['QTY'] . ' </td>
    <td>' . $obj['estweight'] . ' </td>
    </tr></tbody>';
        }
        $table .= '</table>';

        $email = new \SendGrid\Mail\Mail();
        $sendgridConfig = $this->emailConfig['sendgrid'];

        try {
            $email->setFrom($sendgridConfig['from']['ITADSystem'], "ITAD System");
            $email->setSubject('New Stone ITAD Request');
            $email->addTo($this->emailReceiver);

            $content = '
  <!DOCTYPE html>
  <html>
  <head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<title>Collection Request </title>
  </head>
  <body>
  
  <p> Hello,<br/><br/>

<strong>' . $_SESSION['custname'] . '</strong> has submitted a new request.<br/>
RequestID : ' . $_SESSION['rid'] . '.

' . $table . '
</body>
</html>
  ';
            $email->addContent("text/html", $content);
            $sendgrid = new \SendGrid($sendgridConfig['api']['key']);
            $response = $sendgrid->send($email);

            if ($response->statusCode() !== 202) {
                throw new \RuntimeException($response->body());
            }

            echo 'Message has been sent';
        } catch (\Exception $e) {
            Logger::getInstance("torecyclingemailerr.log")->warning($e->getMessage());
        }
    }

    public function toRecycling()
    {
        $imgarrs = array();
        $sql = "select pl.Product,  rd.QTY, Asset_req, Wipe, other1_name, other2_name, other3_name, round(pl.typicalweight, 2) * qty as estweight  from request  as rt
join Req_Detail as rd on
rd.req_id = rt.Request_id
left join productlist as pl with(nolock) on 
pl.product_ID = rd.prod_id
where Request_id =  " . $_SESSION['rid'];
        $stmt = $this->sdb->prepare($sql);
        $stmt->execute();
        $d = $stmt->fetchall(\PDO::FETCH_ASSOC);

        $table = '';
        $table .= '<table class="table">
  <thead>
  <tr>
  <th>  Product </th>
  <th>  Qty </th>
  <th>  est. Weight </th>
  </tr>
  <thead>';

        foreach ($d as $obj) {
            $table .= '<tbody><tr>
    <td>' . $obj['Product'] . ' </td>
    <td>' . $obj['QTY'] . ' </td>
    <td>' . $obj['estweight'] . ' </td>
    </tr></tbody>';
        }

        $table .= '</table>';

        $email = new \SendGrid\Mail\Mail();
        $sendgridConfig = $this->emailConfig['sendgrid'];

        try {
            $email->setFrom($sendgridConfig['from']['ITADSystem'], "ITAD System");
            $email->setSubject('New Stone ITAD Request');
            $email->addTo($this->emailReceiver);

            $sqlpics = "select filename from customerPics where Request_ID = " . $_SESSION['rid'];
            $picstmt = $this->sdb->prepare($sqlpics);
            $picstmt->execute();
            $pics = $picstmt->fetchall(\PDO::FETCH_ASSOC);

            if (isset($pics) && !empty($pics)) {
                Logger::getInstance("attachments.log")->debug('pics', $pics);
                foreach ($pics as $ff) {
                    $fullpath = PROJECT_DIR . self::BOOKING_FOLDER . $ff['filename'];

                    $mimeContentType = mime_content_type($fullpath);

                    $this->compressImage($fullpath, $fullpath, 80);
                    Logger::getInstance("emailruotettachments.log")->debug('fullpath', [$fullpath]);
                    $att1 = new \SendGrid\Mail\Attachment();
                    $att1->setContent(file_get_contents($fullpath));
                    $att1->setType($mimeContentType);
                    $att1->setFilename($ff['filename']);
                    $att1->setDisposition("attachment");
                    $email->addAttachment($att1);
                }
            }

            $content = ' <!DOCTYPE html>
  <html>
  <head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<title>Collection Request </title>
  </head>
  <body>
  
  <p> Hello,<br/><br/>

<strong>' . $_SESSION['custname'] . '</strong> has submitted a new request.<br/>
RequestID : ' . $_SESSION['rid'] . '.

' . $table . '
</body>
</html>';

            $email->addContent("text/html", $content);
            $sendgrid = new \SendGrid($sendgridConfig['api']['key']);
            $response = $sendgrid->send($email);

            if ($response->statusCode() !== 202) {
                throw new \Exception($response->body());
            }
            Logger::getInstance("sent.log")->debug('sent', ['yes']);
            $_SESSION['filestuff'] = '';

            echo 'Message has been sent';
        } catch (\Exception $e) {
            Logger::getInstance("torecyclingemailerr.log")->warning($e->getMessage());
            Logger::getInstance("fail.log")->warning('yes');
        }
        unset($_SESSION['rid']);
    }

    public function compressImage($source_url, $destination_url, $quality)
    {
        if (!file_exists($source_url)) {
            return;
        }

        $info = getimagesize($source_url);
        if ($info['mime'] == 'image/jpeg') {
            $image = imagecreatefromjpeg($source_url);
        } elseif ($info['mime'] == 'image/gif') {
            $image = imagecreatefromgif($source_url);
        } elseif ($info['mime'] == 'image/png') {
            $image = imagecreatefrompng($source_url);
        }

        imagejpeg($image, $destination_url, $quality);
        echo "Image uploaded successfully.";
    }

    public function upload()
    {
        $sql = "select max(request_id)+ 1 as id from request;";
        $stmt = $this->sdb->prepare($sql);
        $stmt->execute();
        $d = $stmt->fetch(\PDO::FETCH_ASSOC);
        $_SESSION['req'] = $d['id'];
        $requestid = $d['id'];

        $filename = [];
        $i = 0;

        if (isset($_FILES['inputfile']['name'])) {
            $filename = $_FILES['inputfile']['name'];
            Logger::getInstance("imagearry.log")->debug('filenames', $filename);
        }

        $filearr = array();
        $reqid = $_SESSION['req'];
        $del = 0;

        if (isset($_POST['del'])) {
            $del = $_POST['del'];
        } else {
            $del = 0;
        }

        Logger::getInstance("isdel.log")->debug('del', [$del]);

        $uploadOk = 1;
        $dir = PROJECT_DIR . self::BOOKING_FOLDER;
        $idpic = 0;

        $sqlupdate = "insert into customerPics(filename, upload_datetime, request_id) values(?, getdate(), ?)";
        $instmt = $this->sdb->prepare($sqlupdate);
        foreach ($filename as $f) {
            $filepic = str_replace($f, 'request', $f);

            $Test = $filepic . $idpic . '-' . $reqid . '.jpg';
            $location = self::UPLOAD_FOLDER . $Test;

            Logger::getInstance("DIR.log")->debug('dir', [$dir . $location]);
            Logger::getInstance("filelist.log")->debug('filelist', [$f]);

            $array = array_values($_FILES['inputfile']['tmp_name']);
            Logger::getInstance("arryselect.log")->debug('arryselect', [$array[$i]]);

            if ($uploadOk == 0) {
                echo 0;
            } else {
                /* Upload file */
                if ($del == 1) {
                    $_SESSION['filestuff'] = '';
                    Logger::getInstance("filenames.log")->debug('location', [$location]);

                    if (file_exists($dir . $location)) {
                        unlink($dir . $location);

                        $delupdate = "delete customerPics where request_id = " . $reqid;
                        $delstmt = $this->sdb->prepare($delupdate);

                        $delstmt->execute();
                    }
                } else {
                    $size = getimagesize($array[$i]);
                    Logger::getInstance("filesize.log")->debug('size', [$size]);
                    $image_type = $size["mime"];

                    Logger::getInstance("imagetypes.log")->debug('imagetypes', [$image_type]);

                    if (copy($array[$i], $dir . $location)) {
                        Logger::getInstance("uploadstatloc.log")->debug('uploadstatloc', [$Test]);

                        $idpic++;
                        $loc =  self::UPLOAD_FOLDER . str_replace('\\', '/', $Test);
                        $filearr[] = $loc;

                        $_SESSION['filestuff'] = $filearr;
                        Logger::getInstance("test.log")->debug('test', [$_SESSION['filestuff']]);

                        $data = [
                            $loc, $reqid,
                        ];

                        $instmt->execute($data);

                        Logger::getInstance("sqlins.log")->debug('sqlins', [$sqlupdate]);
                        Logger::getInstance("uploadstat.log")->debug('uploadstat', [0]);

                        $_SESSION['filestuff'] = '';
                    }
                    Logger::getInstance("failedimg.log")->debug('failedimg', [$array[$i]]);
                }
            }
            $i++;
        }
    }
}
