<?php
namespace App\Controllers;

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
}
