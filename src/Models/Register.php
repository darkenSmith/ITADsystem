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
        try {
            $email = filter_var(stripslashes(strtolower($_POST['email'])), FILTER_SANITIZE_EMAIL);

            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->loadByEmail($email);
            } else {
                Logger::getInstance("Register.log")->info(
                    'email not valid',
                    [
                        'line' => __LINE__,
                        'email' => $email
                    ]
                );
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
                VALUES (:username,:firstname, :lastname,:email, :password, 1, 3, :compnum, :telephone, :number_type, :position, 'N', 'N', 'N', 'N')";
                $result = $this->rdb->prepare($sql);
                $result->execute(
                    [
                        ':username' => $email,
                        ':firstname' => filter_var($_POST['firstname'], FILTER_SANITIZE_STRING),
                        ':lastname' => filter_var($_POST['lastname'], FILTER_SANITIZE_STRING),
                        ':email' => $email,
                        ':compnum' => $this->getFilteredCompanyNumber($_POST['compnum']),
                        ':telephone' => filter_var($_POST['telephone'], FILTER_SANITIZE_STRING),
                        ':number_type' => filter_var($_POST['comptype'], FILTER_SANITIZE_STRING),
                        ':position' => filter_var($_POST['position'], FILTER_SANITIZE_STRING),
                        ':password' => md5($_POST['password'])
                    ]
                );
                $this->user = new \stdClass();
                $this->user->id = $this->rdb->lastInsertId();


                $company_name = filter_var($_POST['companyname'], FILTER_SANITIZE_STRING);
                ///add to company list
                if (!$this->isCompanyExist($company_name)) {
                    try {
                        $sql = 'INSERT INTO `recyc_company_list` ( `company_name`, `portal_requirement`, `assigned_to_bdm`, `cod_required`, `amr_required`, `rebate_required`, `remarketingrep_required`, `blancco_required`, `manual_customer`, `reference_code`, `reference_source`)
                                VALUES(:companyname, 1, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL)';
                        $result = $this->rdb->prepare($sql);
                        $result->execute([
                            ':companyname' => $company_name
                        ]);
                        $companyID = $this->rdb->lastInsertId();

                        $sql = 'INSERT INTO `recyc_customer_links_to_company` (user_id, company_id, `default`)
                         VALUES(:userid, :companyid, 1)';
                        $result = $this->rdb->prepare($sql);
                        $result->execute([
                            ':userid' => $this->user->id,
                            ':companyid' => $companyID
                        ]);

                        $sql = "INSERT INTO recyc_company_sync (company_id, greenoak_id, company_name, CMP) VALUES (:recyc,:greenoak,:company,:cmp)";
                        $result = $this->rdb->prepare($sql);
                        $result->execute(
                            [
                                ':recyc' => $companyID,
                                ':greenoak' => 'AWAITING UPDATE',
                                ':company' => $company_name,
                                ':cmp' => null
                            ]
                        );

                        Logger::getInstance("Register.log")->info(
                            'inserts',
                            [
                                'line' => __LINE__,
                                'user' => $this->user->id,
                                'compid' => $companyID
                            ]
                        );
                    } catch (Exception $e) {
                        Logger::getInstance("Register.log")->error(
                            'inserts',
                            [
                                'line' => $e->getLine(),
                                'line2' => __LINE__,
                                'this->user->id' => $this->user->id,
                                'error' => $e->getMessage()
                            ]
                        );
                    }
                } else {
                    try {
                        $sql = 'INSERT INTO `recyc_customer_links_to_company` (user_id, company_id, `default`)
                     VALUES(:userid, :companyid, 1)';
                        $result = $this->rdb->prepare($sql);
                        $result->execute([':userid' => $this->user->id, ':companyid' => $this->exsitcompany]);

                        $sql = "INSERT INTO recyc_company_sync (company_id, greenoak_id, company_name, CMP) VALUES (:recyc,:greenoak,:company,:cmp)";
                        $result = $this->rdb->prepare($sql);
                        $result->execute(
                            [
                                ':recyc' => $this->exsitcompany,
                                ':greenoak' => 'AWAITING UPDATE',
                                ':company' => $company_name,
                                ':cmp' => null
                            ]
                        );


                        Logger::getInstance("Register.log")->info(
                            'insert',
                            ['line' => __LINE__,
                                'user' => $this->user->id,
                                'compid' => $this->exsitcompany

                            ]
                        );
                    } catch (Exception $e) {
                        Logger::getInstance("Register.log")->error(
                            'failedlink',
                            ['line' => $e->getLine(), 'error' => $e->getMessage()]
                        );
                    }
                }

                // Check if a user id was returned by the insert
                if ($this->user->id) {
                    $this->generateToken();
                    Logger::getInstance("Register.log")->info(
                        'success',
                        [
                            'line' => __LINE__,
                            'this->user->id' => $this->user->id
                        ]
                    );
                    $message = '
                    <div class="alert alert-success fade-in" id="reset-container" >
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4>Success</h4>
                        <p>Thank you for registering.</p>
                    </div>
                    ';
                    return ['success' => true, 'message' => $message];
                } else {
                    Logger::getInstance("Register.log")->warning(
                        'unable to save user',
                        [
                            'line' => __LINE__,
                            'this->user->id' => $this->user->id
                        ]
                    );
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
                Logger::getInstance("Register.log")->warning(
                    'user already exist',
                    [
                        'line' => __LINE__,
                        'email' => $email
                    ]
                );
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

    public function isCompanyExist($companyName)
    {
        $sql = 'SELECT id FROM `recyc_company_list` WHERE company_name = :companyname';
        $result = $this->rdb->prepare($sql);
        $result->execute(array(':companyname' => $companyName));
        $company = $result->fetch(\PDO::FETCH_OBJ);


        if (!empty($company->id)) {
            $this->exsitcompany = $company->id;
            return true;
        }

        return false;
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

    private function getFilteredCompanyNumber($companyNumber)
    {
        $companyNumber = preg_replace(
            '/\s+/',
            '',
            filter_var(
                $companyNumber,
                FILTER_SANITIZE_STRING
            )
        );

        return preg_replace('/[^A-Za-z0-9\-]/', '', $companyNumber);
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
