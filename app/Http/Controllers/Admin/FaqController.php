<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Postmeta;
use Inertia\Inertia;
use DB;
use Auth;
use Str;
class FaqController extends Controller
{
    public function __construct(){
         $this->middleware('permission:faq'); 
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faqs = Post::where('type','faq')->with('excerpt')->latest()->paginate(20);
        $languages = get_option('languages',true);

        $segments = request()->segments();
       
        $buttons = [
            [
                'name'=>'<i class="fa fa-plus"></i>&nbsp'.__('Create FAQ'),
                'url'=>'#',
                'target' => '#addRecord',
            ]
        ];
        return Inertia::render('Admin/Faq/Index',compact('faqs','languages','segments','buttons'));
       
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
            'question'  => 'required|max:150',
            'answer'    => 'required|max:500',
        ]);


        DB::beginTransaction();
        try {
            
           $post = new Post;
           $post->title = $request->question;
           $post->slug  = $request->position ?? 'bottom';
           $post->type  = 'faq';
           $post->lang  = $request->language ?? 'en';
           $post->save();

           $post->excerpt()->create([
            'post_id' => $post->id,
            'key' => 'excerpt',
            'value' => $request->answer,
            ]);

            DB::commit();

        } catch (Throwable $th) {
            DB::rollback();

            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }

        return Inertia::location('/admin/faq');
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

        $request->validate([
            'question'  => 'required|max:150',
            'answer'    => 'required|max:500',
        ]);

        
       DB::beginTransaction();
        try {
            
           $post =  Post::findorFail($id);
           $post->title = $request->question;
           $post->slug  = $request->position ?? 'bottom';
           $post->type  = 'faq';
           $post->lang  = $request->language ?? 'en';
           $post->save();

           $post->excerpt()->update([
            'post_id' => $post->id,
            'key' => 'excerpt',
            'value' => $request->answer,
           ]);

            DB::commit();

        } catch (Throwable $th) {
            DB::rollback();

            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::where('type','faq')->findorFail($id);
        $post->delete();

        return back();
    }
}
