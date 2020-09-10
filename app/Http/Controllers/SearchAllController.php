<?php

namespace App\Http\Controllers;

use App\Entities\SearchAll;
use App\Lib\RestProcessor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SearchAllController extends Controller
{
 public function index()
    {
        $processor = new RestProcessor(SearchAll::class);
        $processor->enableGetAll();
        return $processor->render();
    }
   
}
