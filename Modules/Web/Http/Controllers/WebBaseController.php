<?php

namespace Modules\Web\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\BaseController;

class WebBaseController extends BaseController
{
    protected $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            if(!empty($this->user)){
                View::share('users', $this->user);
            }
            return $next($request);
        });
    }
}
