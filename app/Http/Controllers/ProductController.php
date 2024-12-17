<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

use function Pest\Laravel\json;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories=Category::all();
        $suppliers=Supplier::all();
        $query = Product::with(['category', 'supplier']);

        if ($request->has('low_stock') && $request->low_stock == 1) {
            $query->where('stock', '<', 50);
        }

        if ($request->has('search') && !empty($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('description', 'LIKE', '%' . $request->search . '%');
            });
        }

        if ($request->has('categories') && !empty($request->categories)) {
            $query->whereIn('category_id', $request->categories);
        }

        if ($request->has('suppliers') && !empty($request->suppliers)) {
            $query->whereIn('supplier_id', $request->suppliers);
        }

        $products=$query->paginate(2);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('products.table', compact('products'))->render()
            ]);
        }
        return view('products.index', compact('products','categories','suppliers'));
    }
    public function create(){
        $categories=Category::all();
        $suppliers=Supplier::all();
        return view('products.create',compact('categories','suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description'=>'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
        ]);

        Product::create($request->all());

        return redirect()->route('products')->with('status', 'Product Added successfully!');
    }
    public function edit(int $id){
        $editProduct=Product::findOrFail($id);
        $categories=Category::all();
        $suppliers=Supplier::all();
        return view('products.edit',compact('editProduct','categories','suppliers'));
    }
    public function update(Request $request, int $id){
        $request->validate([
            'name' => 'required|string|max:255|min:2',
            'description'=>'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
        ]);
        $productData=Product::findOrFail($id);
        $productData->update($request->all());
        return redirect()->route('products')->with('status','Product Updated Successfully!');
    }

    public function destroy(Request $request, int $id){
        $deleteProduct=Product::findOrFail($id);
        $deleteProduct->delete();
        return response()->json(['success'=>'Product Deleted']);
    }

}
