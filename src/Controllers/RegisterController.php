<?php
namespace App\Controllers;
use App\Helpers\Config;

use App\Models\Register;

/**
 * Class RegisterController
 * @package App\Controllers
 */
class RegisterController extends AbstractController
{
    public function index() 
    {
        $Conf = new Config();
        $Conf->getlang();
        if (isset($_SESSION['user']['id'])) {
            header('Location: /');
        } else {
            if (isset($_GET['controller']) && isset($_GET['action'])) {
                $redirect = '/login';
            } else {
                $redirect = false;
            }

            $this->template->view(
                'register/register-form',
                [
                    'redirect' => $redirect
                ]
            );
        }
    }

    public function register()
    {
        echo json_encode((new Register())->register());
    }

    public function checkCompany()
    {
        echo json_encode((new Register())->checkCompany());
    }
}
