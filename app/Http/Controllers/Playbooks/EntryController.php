<?php

namespace App\Http\Controllers\Playbooks;

use Illuminate\Http\Request;

use App\Playbooks\Entry;
use App\Playbooks\Category;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Auth;

class EntryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $this->authorize('view', Entry::class);
        $entries = Entry::with('categories')->get();

        $entries = $entries->map(function ($entry) {
            return [
                'id' => $entry->id,
                'title' => str_limit($entry->title, 15),
                'created_at' => $entry->created_at->diffForHumans(),
                'updated_at' => $entry->updated_at->diffForHumans(),
                'categories' => $entry->categories
            ];
        });

        return view('playbooks.entries.index', compact('entries'));
    }

    public function create()
    {
        $this->authorize('create', Entry::class);
        $categories = Category::all();
        return view('playbooks.entries.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Entry::class);
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        $entry = Entry::create([
            'title' => request('title'),
            'body' => request('body'),
            'creator_id' => auth()->id()
        ]);

        if($request->categories) {
            $ids = [];
            foreach ($request->categories as $category) {
                $ids[] = Category::FirstOrCreate(['name' => $category])->id;
            }
            $entry->categories()->attach($ids);
        }
        return redirect()->route('entries.index');
    }

    public function show($id)
    {
        $this->authorize('view', Entry::class);
        $entry = Entry::where('id', $id)->with('categories')->first();
        return view('playbooks.entries.show', compact('entry'));
    }

    public function edit($id)
    {
        $this->authorize('update', Entry::class);
        $entry = Entry::find($id);

        $categories_selected = $entry->categories;
        $categories_remaining = Category::all()->diff($categories_selected);

        return view('playbooks.entries.edit', compact('entry', 'categories_selected', 'categories_remaining'));
    }

    public function update(Request $request, $id)
    {
        $this->authorize('update', Entry::class);
        $entry = Entry::find($id);

        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        $entry->update($request->except('categories'));

        if($request->categories) {
            $ids = [];
            foreach ($request->categories as $category) {
                $ids[] = Category::FirstOrCreate(['name' => $category])->id;
            }
            $entry->categories()->detach();
            $entry->categories()->attach($ids);
        }
        return redirect()->route('entries.show', $id);
    }

    public function destroy($id)
    {
        $this->authorize('delete', Entry::class);
        $entry = Entry::find($id);
        $entry->categories()->detach();
        $entry->delete();
        return redirect()->route('entries.index');
    }
}
