<?php

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

function isRouteActive($route_name){
    return Route::current()->getName() == $route_name;
}