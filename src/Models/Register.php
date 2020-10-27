<?php
namespace App\Models;

use App\Helpers\Config;
use App\Helpers\Logger;
use App\Models\AbstractModel;

class Register extends AbstractModel
{

    public $user;
    /**
     * Register constructor.
     */
    public function __construct()
    {
        $this->emailConfig = Config::getInstance()->get('email');

        parent::__construct();
    }

    public function register()
    {
        try {
            $email = stripslashes(strtolower($_POST['email']));
            $this->loadByEmail($email);

            if (!$this->user) {
                $sql = "INSERT INTO recyc_users (username, firstname,lastname, email, password, active, role_id, CompanyNUM, telephone, number_type, position, `email_preferences`, `post_preferences`, `phone_preferences`) 
                VALUES (:username,:firstname, :lastname,:email, :password, 1, 3, :compnum, :telephone, :number_type, :position, 'N', 'N', 'N')";
                $result = $this->rdb->prepare($sql);
                $result->execute(
                    [
                        ':username' => filter_var($_POST['username'], FILTER_SANITIZE_STRING),
                        ':firstname' => filter_var($_POST['firstname'], FILTER_SANITIZE_STRING),
                        ':lastname' => filter_var($_POST['lastname'], FILTER_SANITIZE_STRING),
                        ':email' => filter_var($_POST['email'], FILTER_SANITIZE_STRING),
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
                $sql = 'INSERT INTO `recyc_company_list` ( `company_name`, `portal_requirement`, `assigned_to_bdm`, `cod_required`, `amr_required`, `rebate_required`, `remarketingrep_required`, `blancco_required`, `manual_customer`, `reference_code`, `reference_source`) VALUES(:companyname, 0, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL)';
                $result = $this->rdb->prepare($sql);
                $result->execute(array(':companyname' => $_POST['companyname']));

                // Get user id just created and init $this->user to stop empty object warning message


                // Check if a user id was returned by the insert
                if ($this->user->id) {
                    $this->generateToken();
                    $message = '
                    <div class="alert alert-success fade-in" id="reset-container" >
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4>Success</h4>
                        <p>thank you for registering.</p>
                    </div>
                    ';
                    return ['success' => true,  'message' => $message];

                } else {
                    $message = '
					<div class="alert alert-danger fade-in" id="reset-container" >
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<h4>Error</h4>
						<p>Unable to save user due to a bad data array.</p>
					</div>
					';
                    return ['success' => false,  'message' => $message];
                }
            } else {
                $message = '
				<div class="alert alert-danger fade-in" id="reset-container" >
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4>Error</h4>
					<p>A user with this email address already exists.</p>
				</div>
				';
                return ['success' => false,  'message' => $message];
            }
        } catch (\Exception $e) {
            $message = '
			<div class="alert alert-danger fade-in" id="reset-container" >
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4>Error</h4>
				<p>A user with this email address already exists.</p>
				<p>' . $e->getMessage() . '</p>
			</div>
			';
            return ['success' => false,  'message' => $message];
        }

        return ['success' => false,  'message' => 'Unable to complete process.'];
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

}
