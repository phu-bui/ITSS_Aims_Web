<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class AdminController extends AdminBaseController
{
    /**
     * Display a listing of the Lab09.
     * @return Renderable
     */
    public function index()
    {
        return view('admin::dashboard.index');
    }


}
