<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Traits\Uploader;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Str;

class CollectionController extends Controller
{
    use Uploader;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $collections = Collection::where('user_id', auth()->id())
            ->with('prompt_previews')
            ->withCount('prompts')
            ->paginate();
        return Inertia::render('Frontend/Account/Collection/Index', [
            'collections' => $collections
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Frontend/Account/Collection/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'preview' => 'required|image|max:5000',
            'name' => 'required|string|max:100',
        ]);

        if ($request->hasFile('preview')) {
            $preview = $this->saveFile($request, 'preview');
        }
        $isNameUnique = Collection::where('name', $request->name)->count();

        $slug = Str::slug($request->name . $isNameUnique > 0 ? $request->name . Str::random(2) : '');

        Collection::create([
            'user_id' => auth()->user()->id,
            'preview' => $preview ?? null,
            'name' => $request->name,
            'slug' => $slug,
        ]);

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Collection $collection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $collection = Collection::where('user_id',auth()->user()->id)->findOrFail($id);

        return Inertia::render('Frontend/Account/Collection/Edit', [
            'collection' => $collection
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $collection = Collection::where('user_id',auth()->user()->id)->findOrFail($id);
        $request->validate([
            'collection.preview' => 'nullable|image|max:5000',
            'collection.name' => 'required|string|max:100',
        ]);

        if ($request->hasFile('collection.preview')) {
            $this->removeFile($collection->preview);
            $preview = $this->saveFile($request, 'collection.preview');
        }
        $isNameUnique = Collection::where('name', $request['collection']['name'])->count();

        $slug = Str::slug($request['collection']['name'] . $isNameUnique > 0 ? $request['collection']['name'] . Str::random(2) : '');

        $collection->update([
            'user_id' => auth()->user()->id,
            'preview' => $preview ?? $collection->preview,
            'name' => $request['collection']['name'],
            'slug' => $slug,
        ]);

        return redirect()->route('user.collection.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Collection $collection)
    {
        abort_if($collection->user_id != auth()->user()->id, 404);
        
        $this->removeFile($collection->preview);
        $collection->delete();
        return back();
    }
}
