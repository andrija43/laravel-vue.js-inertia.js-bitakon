<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Traits\Uploader;
use Inertia\Inertia;

class PartnerController extends Controller
{
    use Uploader;

    public function __construct()
    {
        $this->middleware('permission:partners');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Create a partner'),
                'url' => '#',
                'components' => 'data-toggle="modal" data-target="#addRecord" id="add_record"',
                'is_button' => true,
                'target' => '#addRecord',
            ]
        ];
        $brands         = Category::whereType('brand')->latest()->paginate(10);
        $totalBrands    = Category::whereType('brand')->count();
        $activeBrands   = Category::whereType('brand')->where('status', 1)->count();
        $inActiveBrands = Category::whereType('brand')->where('status', 0)->count();

        return Inertia::render('Admin/Brand/Index', [
            'brands' => $brands,
            'totalBrands' => $totalBrands,
            'activeBrands' => $activeBrands,
            'inActiveBrands' => $inActiveBrands,
            'buttons' => $buttons,
            'segments' => $segments,
        ]);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'url' => ['max:100'],
            'image' => ['required', 'image', 'max:1024'],

        ]);

        $preview = $this->saveFile($request, 'image');

        Category::create([
            'title' => $request->url ?? '#',
            'status' => $request->status,
            'type' => 'brand',
            'slug' => $preview,
            'lang'   => $request->type,
        ]);

        return redirect()->back();
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'partner.title' => ['max:100'],
            'partner.image' => ['nullable', 'image', 'max:1024'],
        ]);

        $brand = Category::where('type', 'brand')->findOrFail($id);

        if ($request->hasFile('partner.image')) {
            $preview = $this->saveFile($request, 'partner.image');
            if (!empty($brand->slug)) {
                $this->removeFile($brand->slug);
            }
        } else {
            $preview = $brand->slug;
        }

        $brand->update([
            'title'  => $data['partner']['title'] ?? '#',
            'status' => $request['partner']['status'],
            'lang'   => $request['partner']['lang'],
            'type'   => 'brand',
            'slug'   => $preview,
        ]);

        return redirect()->route('admin.partner.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Category::findOrFail($id);

        $this->removeFile($brand->slug);

        $brand->delete();

        return redirect()->back();
    }
}
