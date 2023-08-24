<?php

namespace App\Http\Controllers\Employees;

use App\Http\Controllers\Controller;
use App\Models\CategoryEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryEmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $category = CategoryEmployee::all();

        return view('category.index', compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'category_id' => 'required',
            'category_name' => 'required',
        ])->validate();
        //
        CategoryEmployee::create([
            'category_id' => $request->category_id,
            'category_name' => $request->category_name,
        ]);

        return redirect()->route('category')->with('success', 'Thêm loại nhân sự thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $category = CategoryEmployee::findOrFail($id);

        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $category = CategoryEmployee::findOrFail($id);

        $category->update($request->all());

        return redirect()->route('category')->with('success', 'Thay đổi thông tin thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $category = CategoryEmployee::findOrFail($id);

        $category->delete();

        return redirect()->route('category')->with('success', 'Xoá thành công');
    }
}
