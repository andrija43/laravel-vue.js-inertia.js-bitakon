<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Option;
use App\Traits\Uploader;
use Auth;
use Cache;
use Inertia\Inertia;
class SeoController extends Controller
{

    use Uploader;

    public function __construct()
    {
        $this->middleware('permission:seo');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $posts = Option::where('key','LIKE','%seo%')->get()->map(function($query){
            $data['key']     = str_replace('_',' ',str_replace('seo_','',$query->key));
            $data['id']      = $query->id;
            $data['content'] = json_decode($query->value);

            return $data;
       });

        $segments = request()->segments();
        $buttons = [
            
        ];

        return Inertia::render('Admin/Seo/Index', [
            'posts' => $posts,
            'buttons' => $buttons,
            'segments' => $segments,
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $seo = Option::where('key','LIKE','%seo%')->findorFail($id);
        $contents = json_decode($seo->value ?? '');

        $segments = request()->segments();
        $buttons = [
            [
                'name' => __('Back'),
                'url' => route('admin.seo.index'),
            ]
        ];

        return Inertia::render('Admin/Seo/Show', [
            'id' => $id,
            'contents' => $contents,
            'buttons' => $buttons,
            'segments' => $segments,
        ]);

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
       if ($request->image != null) {
        $data = $request->validate([
            'image'  => ['image','max:1024']
        ]);
       }
        

        $meta = $request->metadata ?? '';

        $option   = Option::where('id', $id)->first();
        $contents = json_decode($seo->value ?? '');

        
        if ($request->hasFile('image')) {
           $newImage =  $this->saveFile($request, 'image');
           $meta['preview'] = $newImage;

           if (isset($contents->preview)) {
               if (!empty($contents->preview)) {
                   $this->removeFile($contents->preview);
               }
           }
        }

        $option->value = json_encode($meta);
        $option->save();

        Cache::forget($option->key);

        return back();
    }

   
}
