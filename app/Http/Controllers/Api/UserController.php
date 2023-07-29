<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    const userCategory = ['beginner', 'advanced'];
    const userSettingFormat = [
        'user_category' => 'beginner',
        'notification' => [
            'is_enabled' => false,
            'notifications' => []
        ],
        'is_skip_reminder' => false,
        'goal' => [
            'is_enabled' => true,
            'data' => [
                12 => [
                    'morning' => true,
                    'evening' => false,
                ]
            ]
        ]
    ];
    

}