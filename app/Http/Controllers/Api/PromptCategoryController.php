<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Promptcategoryimage;

class PromptCategoryController extends Controller
{

    /**
     * return the specified resource from storage.
     */
    public function index()
    {
        $promptcategoryimages = Promptcategoryimage::where('promptcategory_id', request()->category_id)->get();

        return response()->json($promptcategoryimages);
    }
}
