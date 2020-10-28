<?php
namespace App\Controllers;

use App\Models\Conf\Confirm;
use App\Models\User;

class RSController extends AbstractController
{
    public function changePasswordApp()
    {
        $this->template->view('RS/chanagepassmob', $this->getCommonData());
    }

    private function getCommonData()
    {
        $data = new User();
        $data->getRoles();
        $roles = $data->roles;

        $data->getCustomers();
        $customers = $data->customers;

        return [
            'customers' => $customers,
            'data' => $data,
            'roles' => $roles,
        ];
    }

    public function updateConf()
    {
        if (!empty($_POST['req'])) {
            echo (new Confirm())->confirmList($_POST['req']);
        } else {
            echo 0;
        }
    }
}
