<?php

namespace App\Http\Controllers\Playbooks;

use Illuminate\Http\Request;

use App\Playbooks\Category;
use App\Http\Controllers\Controller as Controller;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('view', Category::class);
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

    public function create()
    {
        $this->authorize('create', Category::class);
        $categories = Category::all();
        return view('playbooks.categories.create', compact('categories'));
    }

    public function show($id)
    {
        $this->authorize('view', Category::class);
        $category = Category::where('id', $id)->with('entries')->first();
        $entries = $category->entries;

        $entries = $entries->map(function ($entry) {
            return [
                'id' => $entry->id,
                'title' => str_limit($entry->title, 15),
                'created_at' => $entry->created_at->diffForHumans(),
                'updated_at' => $entry->updated_at->diffForHumans(),
                'categories' => $entry->categories
            ];
        });

        return view('playbooks.categories.show', compact('entries', 'category'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Category::class);
        $this->validate($request, [
            'name' => 'required|unique:playbook_categories',
        ]);

        $category = Category::Create(["name" => $request->name]);
        return redirect()->route('categories.index');
    }

    public function edit($id)
    {
        $this->authorize('update', Category::class);
        $category = Category::find($id);
        return view('playbooks.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $this->authorize('update', Category::class);
        $category = Category::find($id);
        $this->validate($request, [
            'name' => 'required|unique:playbook_categories',
        ]);

        $category->update(["name" => $request->name]);
        return redirect()->route('categories.index');
    }

    public function destroy($id)
    {
        $this->authorize('delete', Category::class);
        $category = Category::find($id);
        $category->delete();
        return redirect()->route("categories.index");
    }
}
