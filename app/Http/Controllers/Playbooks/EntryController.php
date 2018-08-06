<?php

namespace App\Http\Controllers\Playbooks;

use Illuminate\Http\Request;

use App\Playbooks\Entry;
use App\Playbooks\Category;
use App\Http\Controllers\Controller as Controller;

class EntryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('playbooks.entries.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $entry = Entry::where('id', $id)->with('categories')->first();
        return view('playbooks.entries.show', compact('entry'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $entry = Entry::find($id);

        $categories_selected = $entry->categories;
        $categories_remaining = Category::all()->diff($categories_selected);

        return view('playbooks.entries.edit', compact('entry', 'categories_selected', 'categories_remaining'));
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $entry = Entry::find($id);
        $entry->categories()->detach();
        $entry->delete();
        return redirect()->route('entries.index');
    }
}
