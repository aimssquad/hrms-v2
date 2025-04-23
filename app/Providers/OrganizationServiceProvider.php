<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;
use DB;

class OrganizationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $email = Session::get("emp_email");
        if ($email) {
            $Roledata = Registration::where("status", "=", "active")
            ->where("email", "=", $email)
            ->first();
            $organizationId = $Roledata->reg; // Adjust this based on your schema

            // Share it across views
            view()->share('currentOrganizationId', $organizationId);

            // Optionally, add to the app container for global access
            app()->instance('currentOrganizationId', $organizationId);

            // Optionally, store it in the session
            Session::put('currentOrganizationId', $organizationId);
        }
    }
}
