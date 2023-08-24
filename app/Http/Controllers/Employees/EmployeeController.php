<?php

namespace App\Http\Controllers\Employees;

use App\Http\Controllers\Controller;
use App\Models\CategoryEmployee;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $employee = Employee::orderBy('id', 'asc')->get();
        $category = CategoryEmployee::orderBy('id', 'asc')->get();

        return view('employee.index', compact('employee', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $category = CategoryEmployee::orderBy('id', 'asc')->get();
        return view('employee.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        Validator::make($request->all(), [
            'ma' => 'required',
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'category_id' => 'required',
            'charge_id' => 'required',
        ])->validate();
        //
        Employee::create([
            'ma' => $request->ma,
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'category_id' => $request->category_id,
            'charge_id' => $request->charge_id
        ]);

        return redirect()->route('employee')->with('success', 'Thêm nhân viên thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $employee = Employee::findOrFail($id);
        $category = CategoryEmployee::orderBy('id', 'asc')->get();
        return view('employee.show', compact('employee', 'category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $employee = Employee::findOrFail($id);
        $category = CategoryEmployee::orderBy('id', 'asc')->get();
        return view('employee.edit', compact('employee', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $employee = Employee::findOrFail($id);

        $employee->update($request->all());

        return redirect()->route('employee')->with('success', 'Thay đổi thông tin thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $employee = Employee::findOrFail($id);

        $employee->delete();

        return redirect()->route('employee')->with('success', 'Xoá thành công');
    }
}
