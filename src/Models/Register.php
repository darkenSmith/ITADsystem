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
        /**
         * @todo form submited
         */
        $values = array();

        try {
            $email = stripslashes(strtolower($_POST['email']));
            $this->loadByEmail($email);

            // Check if user already exists or not
            if (!$this->user) {
                // Build up array from posted values
                // foreach ($_POST as $k => $v) {
                //     if ($k != "customer_id") {
                //         $values[':' . $k] = stripslashes($v);
                //     }
                // }

 

                // Create record for user in recyc_users return the new user id
                $sql = "INSERT INTO recyc_users (username, firstname,lastname, email, password, active, role_id, CompanyNUM, telephone, number_type, position, `email_preferences`, `post_preferences`, `phone_preferences`) VALUES (:username,:firstname, :lastname,:email, 1, 3, :compnum, :telephone, :number_type, :number_type, :position, 'N', 'N', 'N')";
                $result = $this->rdb->prepare($sql);
                $result->execute(array(':username' => $_POST['username'], 
                ':firstname' => $_POST['firstname'], 
                ':lastname' => $_POST['lastname'],
                ':email' => $_POST['email'],
                ':compnum' => $_POST['compnum'],
                ':telephone' => $_POST['telephone'],
                ':number_type' => $_POST['number_type'],
                ':position' => $_POST['position'],
            ));

                ///add to company list
                $sql = 'INSERT INTO `recyc_company_list` ( `company_name`, `portal_requirement`, `assigned_to_bdm`, `cod_required`, `amr_required`, `rebate_required`, `remarketingrep_required`, `blancco_required`, `manual_customer`, `reference_code`, `reference_source`) VALUES(:companyname, 0, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL)';
                $result = $this->rdb->prepare($sql);
                $result->execute(array(':companyname' => $_POST['companyname']));

                // Get user id just created and init $this->user to stop empty object warning message
                $this->user = new \stdClass();
                $this->user->id = $this->rdb->lastInsertId();

                // Check if a user id was returned by the insert
                if ($this->user->id != 0) {
                    // Change tag: addCustomer
                    // Check if adding a user with a customer

                        // Add each custome to the user
                        //foreach($_POST["customer_id"] as $customer_id) {
                        // Insert record
                        // $sql = "INSERT INTO recyc_customer_links_to_company (user_id, company_id) VALUES (:id,:customer_id)";
                        // $statement = $this->rdb->prepare($sql);
                        // $values = array(':id' => $this->user->id, ':customer_id' => $_POST["customer_id"]);
                        // $statement->execute($values);
                        //}
                    
                    // End change tag addCustomer

                    // Generate token and send password change email
                    //$this->get($this->user->id);
                    $this->generateToken();
                   // $this->sendReminder("new");
                } else {
                    // Show error

                    $this->response = '
					<div class="alert alert-danger fade-in" id="reset-container" >
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<h4>Error</h4>
						<p>Unable to save user due to a bad data array.</p>
					</div>
					';
                }

                $this->response = '
				<div class="alert alert-success fade-in" id="reset-container" >
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4>Profile Updated</h4>
					<p>User updated successfully</p>
				</div>
				';
            } else {
                $this->response = '
				<div class="alert alert-danger fade-in" id="reset-container" >
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4>Error</h4>
					<p>A user with this email address already exists.</p>
				</div>
				';
            }
        } catch (\Exception $e) {
            $this->response = '
			<div class="alert alert-danger fade-in" id="reset-container" >
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4>Error</h4>
				<p>A user with this email address already exists.</p>
				<p>' . $e->getMessage() . '</p>
			</div>
			';
        }
        return ['success' => true];
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

    public function get($id = false)
    {

        if ($id) {
            $sql = 'SELECT
				id,
				username,
				firstname,
				lastname,
				email,
				active,
				role_id,
				password
			FROM
				recyc_users
			WHERE
				id = :id
			';
            $result = $this->rdb->prepare($sql);
            $result->execute(array(':id' => $id));
            $this->user = $result->fetch(\PDO::FETCH_OBJ);

            // $sql   = 'SELECT structure_id FROM recyc_permissions WHERE role_id = :role';
            // $result = $this->rdb->prepare( $sql );
            // $result->execute(array(':role' => $this->user->role_id));
            // $this->user->permissions = $result->fetchAll(\PDO::FETCH_OBJ );

            $sql = 'SELECT
				c.id,
				c.company_name
			FROM
				recyc_customer_links_to_company cc
			left join
				recyc_company_list c on cc.company_id = c.id
			where
				user_id = :id
			';
            $result = $this->rdb->prepare($sql);
            $result->execute(array(':id' => $id));
            $this->user->companies = $result->fetchAll(\PDO::FETCH_OBJ);

            $sql = 'SELECT
				c.id,
				c.company_name
			from
				recyc_customer_links_to_company cc
			left join
				recyc_company_list c on cc.company_id = c.id
			where
				user_id = :id
			';
            $result = $this->rdb->prepare($sql);
            $result->execute(array(':id' => $id));
            $this->user->customers = $result->fetchAll(\PDO::FETCH_OBJ);
        } else {
            $sql = 'SELECT * FROM recyc_users WHERE (role_id = 1 OR role_id = 2)';
            $result = $this->rdb->prepare($sql);
            $result->execute();
            $this->stoneUsers = $result->fetchAll(\PDO::FETCH_OBJ);

            $sql = 'SELECT * FROM recyc_users WHERE (role_id = 3 OR role_id = 4)"';
            $result = $this->rdb->prepare($sql);
            $result->execute();
            $this->users = $result->fetchAll(\PDO::FETCH_OBJ);
        }
    }

}
