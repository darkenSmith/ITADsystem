<?php

namespace App\Controllers;

use App\Models\Overview;

/**
 * Class PagesController
 * @package App\Controllers
 */
class PagesController extends AbstractController
{

    public function error(): void
    {
        $this->template->view(
            'pages/error'
        );
    }

    public function home(): void
    {
        set_time_limit(0);

        $info = new Overview();
        $info->route();

        $this->template->view(
            $info->page,
            [
                'info' => $info
            ]
        );
    }
}
