<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer\DichVuCustomter;
use App\Models\Customer\InfoCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $customer = InfoCustomer::orderBy('id', 'asc')->get();
        return view('customer.index', compact('customer'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $dichvu = DichVuCustomter::orderBy('id', 'asc')->get();
        return view('customer.create', compact('dichvu'));
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
            'loai_dv' => 'required',
            'phone' => 'required',
            'email' => 'required'
        ])->validate();
        //
        InfoCustomer::create([
            'ma' => $request->ma,
            'name' => $request->name,
            'address' => $request->address,
            'loai_dv' => $request->loai_dv,
            'phone' => $request->phone,
            'email' => $request->email
        ]);
        return redirect()->route('customer')->with('success', 'Thêm thông tin khách hàng thành công');
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
