<?php
namespace App\Controllers;

use App\Models\Register;

/**
 * Class RegisterController
 * @package App\Controllers
 */
class RegisterController extends AbstractController
{
    public function index()
    {
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
}
