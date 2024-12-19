<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index(Request $request){
        $suppliers=Supplier::withCount('products')->paginate(2);
        if ($request->ajax()) {
            return response()->json([
                'html' => view('suppliers.table', compact('suppliers'))->render()
            ]);
        }
        return view('suppliers.index',compact('suppliers'));
    }
    public function create(){
        return view('suppliers.create');
    }
    public function checkEmail(Request $request){
        $exists=Supplier::where('email',$request->email)->exists();
        return response()->json(!$exists); //Returns flase if already exists.
    }
    public function store(Request $request){
        $request->validate([
            'name'=>'required|string|max:255',
            'email' => 'required|email|unique:suppliers,email',
            'phone' => 'nullable|regex:/^[0-9]{10}$/',
            'address'=>'required'
        ]);
        Supplier::create($request->all());
        return redirect()->route('suppliers')->with('status','Supplier Is Created!!');
    }
    public function edit(int $id){
        $supplierData=Supplier::findOrFail($id);
        return view('suppliers.edit',compact('supplierData'));
    }
    public function update(Request $request, int $id)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'phone' => 'nullable|regex:/^[0-9]{10}$/',
            'address'=>'required'
        ]);
        $supplier=Supplier::findOrFail($id);
        $supplier->update([
            'name'=>$request->name,
            'phone'=>$request->phone,
            'address'=>$request->address
        ]);
        return redirect()->route('suppliers')->with('status','Category Updated Successfylly...');
    }
    public function destroy(int $id){
        $supplier=Supplier::findOrFail($id);
        $supplier->delete();
        return response()->json(['status'=>'Supplier Deleted!']);
    }
}
