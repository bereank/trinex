<?php

namespace App\Http\View;

use BereanK\Integrator\Services\ConfigProviderService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MenuComposer
{
    public function compose(View $view)
    {


        if (auth()->check()) {

            $userDbs = Auth::user()->databases;
            foreach ($userDbs as $key => $database) {

                // $configs = (new ConfigProviderService())->configs($database->client_id);

                // $database->CompanyName = $configs['COMPANY_NAME'];
            }

            $view->with('userDbs', $userDbs);
        }
    }
}
