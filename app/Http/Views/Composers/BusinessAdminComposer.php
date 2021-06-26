<?php


namespace App\Http\Views\Composers;


use Illuminate\View\View;

class BusinessAdminComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with([
            'isAdminBusiness'=>\Request::is('businesses-admin/*'),
        ]);
    }
}
