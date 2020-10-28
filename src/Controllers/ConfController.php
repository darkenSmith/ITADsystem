<?php
namespace App\Controllers;

/**
 * Class ConfController
 * @package App\Controllers
 */
class ConfController extends AbstractController
{
    public function thankyoucust()
    {
        $this->template->view('RS/thankyou', []);
    }
}
