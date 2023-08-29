<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer\DichVuCustomter;
use App\Models\Customer\InfoCustomer;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Google\Client;
use Google\Service\Drive;

class CustomerController extends Controller
{
    public $gClient;

    function __construct()
    {

        $this->gClient = new \Google_Client();

        $this->gClient->setApplicationName('CongTyTTP'); // ADD YOUR AUTH2 APPLICATION NAME (WHEN YOUR GENERATE SECRATE KEY)
        $this->gClient->setClientId('1091359250863-m7kesaujlcpgje4vvckph3dak496u56s.apps.googleusercontent.com');
        $this->gClient->setClientSecret('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');
        $this->gClient->setRedirectUri(route('google.login'));
        $this->gClient->setDeveloperKey('AIzaSyB3bTFWcfDr_9rDrp3hkrbGRaOEHYi6udo');
        $this->gClient->setScopes(array(
            'https://www.googleapis.com/auth/drive.file',
            'https://www.googleapis.com/auth/drive'
        ));

        $this->gClient->setAccessType("offline");

        $this->gClient->setApprovalPrompt("force");
    }
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

    public function driveCreateFolder(string $folder_name)
    {
        $service = new \Google\Service\Drive($this->gClient);

        $user = User::find(1);

        $this->gClient->setAccessToken(json_decode($user->access_token, true));

        if ($this->gClient->isAccessTokenExpired()) {

            // SAVE REFRESH TOKEN TO SOME VARIABLE
            $refreshTokenSaved = $this->gClient->getRefreshToken();

            // UPDATE ACCESS TOKEN
            $this->gClient->fetchAccessTokenWithRefreshToken($refreshTokenSaved);

            // PASS ACCESS TOKEN TO SOME VARIABLE
            $updatedAccessToken = $this->gClient->getAccessToken();

            // APPEND REFRESH TOKEN
            $updatedAccessToken['refresh_token'] = $refreshTokenSaved;

            // SET THE NEW ACCES TOKEN
            $this->gClient->setAccessToken($updatedAccessToken);

            $user->access_token = $updatedAccessToken;

            $user->save();
        }
        try {
            $fileMetadata = new Drive\DriveFile(array(
                'name' => $folder_name,
                'mimeType' => 'application/vnd.google-apps.folder'
            ));
            $file = $service->files->create($fileMetadata, array(
                'fields' => 'id'
            ));
            // printf("Folder ID: %s\n", $file->id);
            return $file->id;
        } catch (Exception $e) {
            echo "Error Message: " . $e;
        }
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
        $folder_id = CustomerController::driveCreateFolder($forlder_name);
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

    /**
     * Display the specified resource.
     */
    public function exportFile($fileId)
    {
        $service = new \Google\Service\Drive($this->gClient);

        // $user = User::find(1);

        // $this->gClient->setAccessToken(json_decode($user->access_token, true));

        // if ($this->gClient->isAccessTokenExpired()) {

        //     // SAVE REFRESH TOKEN TO SOME VARIABLE
        //     $refreshTokenSaved = $this->gClient->getRefreshToken();

        //     // UPDATE ACCESS TOKEN
        //     $this->gClient->fetchAccessTokenWithRefreshToken($refreshTokenSaved);

        //     // PASS ACCESS TOKEN TO SOME VARIABLE
        //     $updatedAccessToken = $this->gClient->getAccessToken();

        //     // APPEND REFRESH TOKEN
        //     $updatedAccessToken['refresh_token'] = $refreshTokenSaved;

        //     // SET THE NEW ACCES TOKEN
        //     $this->gClient->setAccessToken($updatedAccessToken);

        //     $user->access_token = $updatedAccessToken;

        //     $user->save();
        // }
        try {
            $content = $service->files->get($fileId, array("alt" => "media"));
            return $content;
        } catch (Exception $e) {
            echo "Error Message: " . $e;
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
