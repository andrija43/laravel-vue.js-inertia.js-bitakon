<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Traits\Uploader;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CollectionController extends Controller
{
    use Uploader;

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $segments = request()->segments();
        $buttons = [];
        $collections = Collection::query()
            ->with(['user:id,name,created_at'])
            ->withCount('prompts')
            ->paginate(10);
        $totalCollection = Collection::query()->count();
        $activeCollection = Collection::query()->where('status', 1)->count();
        $inactiveCollection = Collection::query()->where('status', 0)->count();

        return Inertia::render('Admin/Collection/Index', [
            'collections' => $collections,
            'buttons' => $buttons,
            'segments' => $segments,
            'totalCollection' => $totalCollection,
            'activeCollection' => $activeCollection,
            'inactiveCollection' => $inactiveCollection,
        ]);
    }

    public function update(Request $request, $id)
    {
        $collection = Collection::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $collection->update([
            'name' => $request->name,
            'status' => $request->status ?? $collection->status,
            'is_featured' => $request->is_featured ?? $collection->is_featured,
        ]);

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
        $collection = Collection::findOrFail($id)->delete();
        $this->removeFile($collection->preview);
        return back();
    }
}
