<?php

namespace App\Http\Controllers\Playbooks;

use Illuminate\Http\Request;

use App\Playbooks\Category;
use App\Http\Controllers\Controller as Controller;

class CategoryController extends Controller
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
        $categories = Category::all();
        $categories = $categories->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => str_limit($category->name, 30),
                'entries' => count($category->entries)
            ];
        });
        return view('playbooks.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('playbooks.categories.create', compact('categories'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::where('id', $id)->with('entries')->first();
        $entries = $category->entries;

        $entries = $entries->map(function ($entry) {
            return [
                'id' => $entry->id,
                'title' => str_limit($entry->title, 15),
//                'creator' => str_limit($entry->creator->name, 10),
                'created_at' => $entry->created_at->diffForHumans(),
                'updated_at' => $entry->updated_at->diffForHumans(),
                'categories' => $entry->categories
            ];
        });

        return view('playbooks.categories.show', compact('entries', 'category'));
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
            'name' => 'required|unique:categories',
        ]);

        $category = Category::Create(["name" => $request->name]);
        return redirect()->route('categories.index');
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('playbooks.categories.edit', compact('category'));
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
        $category = Category::find($id);
        $this->validate($request, [
            'name' => 'required|unique:categories',
        ]);

        $category->update(["name" => $request->name]);
        return redirect()->route('categories.index');
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect()->route("categories.index");
    }
}
