<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request){
        $categories=Category::withCount('products')->paginate(2);
        if ($request->ajax()) {
            return response()->json([
                'html' => view('categories.table', compact('categories'))->render()
            ]);
        }
        return view('categories.index',compact('categories'));
    }
    public function create(){
        return view('categories.create');
    }
    public function checkName(Request $request) {
        $exists=Category::where('name',$request->name)->exists();
        return response()->json(!$exists);
    }
    public function store(Request $request){
        $request->validate([
            'name'=>'unique:categories,name|required|string|max:255|min:2',
            'description'=>'nullable|string'
        ]);
        Category::create($request->all());
        return redirect()->route('categories')->with('status','Category Added Successfully!');
    }
    public function edit($id){
        //$editCategory=Category::findOrFail($id);
        $editCategory=Category::findOrFail($id);
        return view('categories.edit',compact('editCategory'));
    }
    Public function update(Request $request,int $id){
        $request->validate([
            'name'=>'required|string|max:255',
            'description'=>'nullable|string'
        ]);
        $category=Category::findOrFail($id);
        $category->update([
            'name'=>$request->name,
            'description'=>$request->description
        ]);

        return redirect()->route('categories')->with('status','Category Updated');
    }
    public function destroy($id)
    {
        $deleteData = Category::findOrFail($id);
        $deleteData->delete();

        return response()->json(['status'=>'Record Deleted Successfully!']);
    }
}
