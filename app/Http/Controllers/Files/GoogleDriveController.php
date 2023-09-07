<?php

namespace App\Http\Controllers\Files;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Files\Folder;
use Exception;
use finfo;
use Google\Client;
use Google\Service\Drive;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits;
use App\Http\Traits\FileTrait;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

use function Ramsey\Uuid\v1;

class GoogleDriveController extends Controller
{
    use FileTrait;

    public function googleLogin(Request $request)
    {

        $google_oauthV2 = new \Google\Service\Oauth2($this->gClient);

        if ($request->get('code')) {

            $this->gClient->authenticate($request->get('code'));

            $request->session()->put('token', $this->gClient->getAccessToken());
        }

        if ($request->session()->get('token')) {

            $this->gClient->setAccessToken($request->session()->get('token'));
        }

        if ($this->gClient->getAccessToken()) {

            //FOR LOGGED IN USER, GET DETAILS FROM GOOGLE USING ACCES
            $user = User::find(1);

            $user->access_token = json_encode($request->session()->get('token'));

            $user->save();

            dd("Successfully authenticated");
        } else {

            // FOR GUEST USER, GET GOOGLE LOGIN URL
            $authUrl = $this->gClient->createAuthUrl();

            return redirect()->to($authUrl);
        }
    }
    public function getParentFolderId(string $fileId)
    {
        $service = new \Google\Service\Drive($this->gClient);

        $file = $service->files->get($fileId, array('fields' => 'parents'));
        $rootId = $service->files->get('root')->getId();

        $parents = $file->getParents();
        if (!empty($parents)) {
            $parent = $parents[0];
            if (strcmp($rootId, $parent) == 0) {
                return null;
            }
            return $parent;
        } else {
            return null;
        }
    }
    public function upPermission(string $emailUser, string $folderId)
    {
        $service = new \Google\Service\Drive($this->gClient);
        $this->OAuth2();
        // Create a new permission
        $permission = new \Google\Service\Drive\Permission();
        $permission->setEmailAddress($emailUser);
        $permission->setType('user');
        $permission->setRole('writer');

        // Insert the permission
        $result = $service->permissions->create($folderId, $permission);
    }
    public function listFile(string $folder_id)
    {
        $service = new \Google\Service\Drive($this->gClient);
        $this->OAuth2();
        $optParams = array(
            'corpora' => "allDrives",
            'pageSize' => 100,
            'fields' => "nextPageToken, files(contentHints/thumbnail,fileExtension,iconLink,id,name,size,thumbnailLink,webContentLink,webViewLink,mimeType,parents,modifiedTime)",
            'q' => "'" . $folder_id . "' in parents",
            'includeItemsFromAllDrives' => 'true',
            'supportsAllDrives' => 'true'
        );
        $files = $service->files->listFiles($optParams);
        $parentsId = GoogleDriveController::getParentFolderId($folder_id);
        return view('customer.listFile', compact('files', 'parentsId', 'folder_id'));
    }
    public function searchNameFile(Request $request)
    {
        $service = new \Google\Service\Drive($this->gClient);
        $this->OAuth2();
        // Tìm kiếm tệp tin với tên
        $search  = "";
        $search = $request->input('search');
        $folder_id = $request->input('folder_id');
        $parentsId = GoogleDriveController::getParentFolderId($folder_id);
        $files = null;
        if ($search != "") {
            $optParams = array(
                'pageSize' => 100,
                'fields' => "nextPageToken, files(contentHints/thumbnail,fileExtension,iconLink,id,name,size,thumbnailLink,webContentLink,webViewLink,mimeType,parents,modifiedTime)",
                'q' => "name contains '" . $search . "'",
                'includeItemsFromAllDrives' => 'true',
                'supportsAllDrives' => 'true'
            );
            $files = $service->files->listFiles($optParams);
        }
        // Trả về tên tệp tin
        return view('customer.listFile', compact('files', 'parentsId', 'folder_id', 'search'));
    }
    public function googleDriveFileUpload(Request $request)
    {
        $service = new \Google\Service\Drive($this->gClient);
        $this->OAuth2();
        try {
            if ($request->hasFile('file')) {
                $file = $request->file('fileup');
                $folder_id = $request->input('forder_id');
                $fileMetadata = new \Google\Service\Drive\DriveFile([
                    'name' => $_FILES['file']['name'],
                    'minType' => $_FILES['file']['type'],
                    'parents' => [$folder_id],
                ]);
                $file = $_FILES['file']['tmp_name'];
                $service->files->create($fileMetadata, array(
                    'data' => file_get_contents($file),
                    'uploadType' => 'multipart',
                ));
                return redirect()->back()->with('success', 'Upload file thành công');
            }
            return redirect()->back()->with('error', 'Vui lòng chọn file upload');
        } catch (Exception $e) {
            echo "Error Message: " . $e;
        }
    }
    public function googleDriveCreateFolder(Request $request)
    {
        if (!empty($request->input('forder_name'))) {
            $parent_id = $request->input('parent_id');
            $forlder_name = $request->input('forder_name');
            if ($this->driveCreateFolderInFolder($forlder_name, $parent_id)) {
                return redirect()->back()->with('success', 'Tạo folder thành công');
            };
        }
        return redirect()->back()->with('error', 'Vui lòng nhập tên folder');
    }
}
