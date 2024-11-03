<?php

namespace App\Http\Controllers;

use App\Enums\Boolean;
use App\Models\Recipe;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public $recipe_model;

    public function __construct()
    {
        // Model
        $this->recipe_model = new Recipe();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Set custom url path for show recipe back button
        session(['customPrevURL' => parse_url(url()->current(), PHP_URL_PATH)]);

        $items = $this->recipe_model->get_all_recipes();
        
        return view('web.member.index', compact('items'));
    }

}
