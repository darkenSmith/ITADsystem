<?php

namespace App\Models;

use App\Helpers\Logger;
use Exception;


/**
 * Class Register
 * @package App\Models
 */
class Register extends AbstractModel
{
    public $user;
    public $exsitcompany;

    /**
     * Register constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function register()
    {
        // Logger::getInstance("Register1.log")->info(
        //     'failedlink',
        //     ['line' => __LINE__]
        // );
        // exit;
        try {
            $email = filter_var(stripslashes(strtolower($_POST['email'])), FILTER_SANITIZE_EMAIL);

            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->loadByEmail($email);
            } else {
                $message = '
				<div class="alert alert-danger fade-in" id="reset-container" >
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4>Error</h4>
					<p>E-mail address is not valid.</p>
				</div>';
                return ['success' => false, 'message' => $message];
            }

            if (!$this->user) {
                $sql = "INSERT INTO recyc_users (username, firstname,lastname, email, password, active, role_id, CompanyNUM, telephone, number_type, position, `email_preferences`, `post_preferences`, `phone_preferences`, `approved`) 
                VALUES (:username,:firstname, :lastname,:email, :password, 1, 3, :compnum, :telephone, :number_type, :position, 'N', 'N', 'N', 'Y')";
                $result = $this->rdb->prepare($sql);
                $result->execute(
                    [
                        ':username' => $email,
                        ':firstname' => filter_var($_POST['firstname'], FILTER_SANITIZE_STRING),
                        ':lastname' => filter_var($_POST['lastname'], FILTER_SANITIZE_STRING),
                        ':email' => $email,
                        ':compnum' => filter_var($_POST['compnum'], FILTER_SANITIZE_STRING),
                        ':telephone' => filter_var($_POST['telephone'], FILTER_SANITIZE_STRING),
                        ':number_type' => filter_var($_POST['comptype'], FILTER_SANITIZE_STRING),
                        ':position' => filter_var($_POST['position'], FILTER_SANITIZE_STRING),
                        ':password' => md5($_POST['password'])
                    ]
                );
                $this->user = new \stdClass();
                $this->user->id = $this->rdb->lastInsertId();

                ///add to company list
                if (!$this->isCompanyExist(filter_var($_POST['companyname'], FILTER_SANITIZE_STRING))) {
                    $sql = 'INSERT INTO `recyc_company_list` ( `company_name`, `portal_requirement`, `assigned_to_bdm`, `cod_required`, `amr_required`, `rebate_required`, `remarketingrep_required`, `blancco_required`, `manual_customer`, `reference_code`, `reference_source`) VALUES(:companyname, 0, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL)';
                    $result = $this->rdb->prepare($sql);
                    $result->execute(array(':companyname' => filter_var($_POST['companyname'], FILTER_SANITIZE_STRING)));
                    $companyID = $this->rdb->lastInsertId();

                    $sql = 'INSERT INTO `recyc_customer_links_to_company` (user_id, company_id, `default`)
                     VALUES(:userid, :companyid, 1)';
                    $result = $this->rdb->prepare($sql);
                    $result->execute(array(':userid' => $this->user->id, ':companyid' => $companyID));

                    Logger::getInstance("Register1.log")->info(
                        'failedlink',
                        ['line' => __LINE__,
                        'user' => $this->user->id,
                        'compid' => $companyID
                        
                        ]
                    );

                }else{

                    
                    $sql = 'INSERT INTO `recyc_customer_links_to_company` (user_id, company_id, `default`)
                     VALUES(:userid, :companyid, 1)';
                      try{
                          
                    Logger::getInstance("Register1.log")->info(
                        'failedlink',
                        ['line' => __LINE__,
                        'user' => $this->user->id,
                        'compid' => $this->exsitcompany
                        
                        ]
                    );
                    $result = $this->rdb->prepare($sql);
                    $result->execute(array(':userid' => $this->user->id, ':companyid' => $this->exsitcompany));
                    }catch(Exception $e){

                        Logger::getInstance("Register1.log")->error(
                            'failedlink',
                            ['line' => $e->getLine(), 'error' => $e->getMessage()]
                        );

                    }
               

                }

                // Check if a user id was returned by the insert
                if ($this->user->id) {
                    $this->generateToken();
                    $message = '
                    <div class="alert alert-success fade-in" id="reset-container" >
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4>Success</h4>
                        <p>Thank you for registering.</p>
                    </div>
                    ';
                    return ['success' => true, 'message' => $message];
                } else {
                    $message = '
					<div class="alert alert-danger fade-in" id="reset-container" >
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<h4>Error</h4>
						<p>Unable to save user.</p>
					</div>
					';
                    return ['success' => false, 'message' => $message];
                }
            } else {
                $message = '
				<div class="alert alert-danger fade-in" id="reset-container" >
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4>Error</h4>
					<p>A user with this email address already exists.</p>
				    <p><a href="/login">Login</a></p>
				</div>
				';
                return ['success' => false, 'message' => $message];
            }
        } catch (\Exception $e) {
            Logger::getInstance("Register.log")->error(
                'failed',
                ['line' => $e->getLine(), 'error' => $e->getMessage()]
            );
            $message = '
			<div class="alert alert-danger fade-in" id="reset-container" >
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4>ERROR!</h4>
				<p>Can not complete the process.</p>
			</div>
			';
            return ['success' => false, 'message' => $message];
        }

        return ['success' => false, 'message' => 'Unable to complete process.'];
    }

    public function loadByEmail($email)
    {
        $email = strtolower($email);
        if ($email) {
            $sql = 'SELECT * FROM recyc_users WHERE email = :email';
            $result = $this->rdb->prepare($sql);
            $result->execute(array(':email' => $email));
            $this->user = $result->fetch(\PDO::FETCH_OBJ);
        }
    }

    public function generateToken()
    {
        $length = 32;
        $this->token = bin2hex(random_bytes($length));
        $expires = new \DateTime();
        $expires->modify('+2 days');
        $this->expiry = $expires->format('Y-m-d H:i:s');

        $sql = 'UPDATE recyc_users SET token = :token, token_expires = :expiry WHERE id = :id';
        $values = array(':token' => $this->token, ':expiry' => $this->expiry, ':id' => $this->user->id);
        $result = $this->rdb->prepare($sql);
        $result->execute($values);
    }

    public function isCompanyExist($companyName)
    {
        $sql = 'SELECT id FROM `recyc_company_list` WHERE company_name = :companyname';
        $result = $this->rdb->prepare($sql);
        $result->execute(array(':companyname' => $companyName));
        $company = $result->fetch(\PDO::FETCH_OBJ);
        

        if (!empty($company['id'])) {
            $this->exsitcompany = $company['id'];
            return true;
        }

        return false;
    }

    private function passValidation($pass)
    {
        if (strlen($pass) > 20 ||
            strlen($pass) < 5) {
            return false;
        }
        return true;
    }
}
