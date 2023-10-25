<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promptcategoryimage;
use App\Traits\Uploader;
use Illuminate\Http\Request;

class PromptCategoryImageController extends Controller
{
    use Uploader;
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required|image|max:5000',
            'name' => 'required|string|max:100',
        ]);
        if ($request->hasFile('url')) {
            $image = $this->saveFile($request, 'url');
        }
        Promptcategoryimage::create([
            'name' => $request->name,
            'promptcategory_id' => $request->promptcategory_id,
            'url' => $image,
        ]);
        return back();
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $promptcategoryimage = Promptcategoryimage::findOrFail($id);
        $request->validate([
            'categoryImage.url' => 'required|image|max:5000',
            'categoryImage.name' => 'required|string|max:100',
        ]);
        if ($request->hasFile('categoryImage.url')) {
            $image = $this->saveFile($request, 'categoryImage.url');
        }
        $promptcategoryimage->update(
            [
                'name' => $request['categoryImage']['name'],
                'url' => $image ?? $promptcategoryimage->url,
            ]
        );
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $promptcategoryimage = Promptcategoryimage::findOrFail($id);
        $this->removeFile($promptcategoryimage->url);
        $promptcategoryimage->delete();
        return back();
    }
}
