<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Traits\FileTrait;
use App\Models\Customer\DichVuCustomter;
use App\Models\Customer\InfoCustomer;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Google\Client;
use Google\Service\Drive;
use App\Http\Traits;

class CustomerController extends Controller
{
    use FileTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $customer = InfoCustomer::orderBy('id', 'asc')->get();
        $dichvu = DichVuCustomter::orderBy('id', 'asc')->get();
        return view('customer.index', compact('customer', 'dichvu'));
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
        $forlder_name = $request->name . '_' .  $request->ma;
        $folder_id = $this->driveCreateFolder($forlder_name);
        if ($folder_id) {
            InfoCustomer::create([
                'ma' => $request->ma,
                'name' => $request->name,
                'address' => $request->address,
                'loai_dv' => $request->loai_dv,
                'phone' => $request->phone,
                'email' => $request->email,
                'folder_id' => $folder_id,
            ]);
            return redirect()->route('customer')->with('success', 'Thêm thông tin khách hàng thành công');
        }
    }
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
