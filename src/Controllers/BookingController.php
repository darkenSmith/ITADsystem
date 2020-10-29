<?php

namespace App\Controllers;

use App\Models\Booking;
use App\Models\Collection;

/**
 * Class BookingController
 * @package App\Controllers
 */
class BookingController extends AbstractController
{

    public function index(): void
    {
        $collections = new Collection();
        $collections->getCollections();
        $collections = $collections->collections;

        $this->template->view(
            'collection/list',
            [
                'collections' => $collections
            ]
        );
    }

    public function request(): void
    {
        if ($_SESSION['user']['approved'] == 1) {

            $this->template->view(
            'booking/request-form',
             []
                );
                }else{
                    $this->template->view(
                        'register/register-form',
                        []
                    );
                }
    }

    public function update(): void
    {

        $booking = new Booking();
        $booking->updateTables();

        $this->template->view(
            'booking/request-form',
            []
        );
    }

    public function thankYou(): void
    {
        $this->template->view(
            'booking/thank-you',
            []
        );
    }

    public function upload(): void
    {
        $booking = new Booking();
        $booking->upload();
    }
}
