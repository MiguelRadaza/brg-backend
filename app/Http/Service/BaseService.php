<?php

namespace App\Http\Service;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

class BaseService 
{
    use AuthorizesRequests, ValidatesRequests;
    
}
