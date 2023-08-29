<?php

namespace App\Http\Controllers\Files;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Files\Folder;
use Exception;
use Google\Client;
use Google\Service\Drive;

use function Ramsey\Uuid\v1;

class GoogleDriveController extends Controller
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
    public function listFile(string $folder_id)
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
        $optParams = array(
            'corpora' => "allDrives",
            'pageSize' => 100,
            'fields' => "nextPageToken, files(contentHints/thumbnail,fileExtension,iconLink,id,name,size,thumbnailLink,webContentLink,webViewLink,mimeType,parents,modifiedTime)",
            'q' => "'" . $folder_id . "' in parents",
            'includeItemsFromAllDrives' => 'true',
            'supportsAllDrives' => 'true'
        );
        $files = $service->files->listFiles($optParams);
        $folder = Folder::where('folder_id', $folder_id)->get();
        return view('customer.listFile', compact('files', 'folder'));
    }

    // public function fetchAppDataFolder()
    // {
    //     $service = new \Google\Service\Drive($this->gClient);

    //     $user = User::find(1);

    //     $this->gClient->setAccessToken(json_decode($user->access_token, true));

    //     if ($this->gClient->isAccessTokenExpired()) {

    //         // SAVE REFRESH TOKEN TO SOME VARIABLE
    //         $refreshTokenSaved = $this->gClient->getRefreshToken();

    //         // UPDATE ACCESS TOKEN
    //         $this->gClient->fetchAccessTokenWithRefreshToken($refreshTokenSaved);

    //         // PASS ACCESS TOKEN TO SOME VARIABLE
    //         $updatedAccessToken = $this->gClient->getAccessToken();

    //         // APPEND REFRESH TOKEN
    //         $updatedAccessToken['refresh_token'] = $refreshTokenSaved;

    //         // SET THE NEW ACCES TOKEN
    //         $this->gClient->setAccessToken($updatedAccessToken);

    //         $user->access_token = $updatedAccessToken;

    //         $user->save();
    //     }

    //     try {
    //         $folder = array();
    //         $pageToken = null;
    //         do {
    //             $response = $service->files->get(array(
    //                 'q' => "application/vnd.google-apps.folder",
    //                 'spaces' => 'drive',
    //                 'pageToken' => $pageToken,
    //                 'fields' => 'nextPageToken, files(id, name)',
    //             ));
    //             foreach ($response->folder as $folder) {
    //                 printf("Found file: %s (%s)\n", $folder->name, $folder->id);
    //             }
    //             array_push($folder, $response->files);

    //             $pageToken = $response->pageToken;
    //         } while ($pageToken != null);
    //         return $folder;
    //     } catch (Exception $e) {
    //         echo "Error Message: " . $e;
    //     }
    // }

    // public function googleDriveFilePpload()
    // {
    //     $service = new \Google\Service\Drive($this->gClient);

    //     $user = User::find(1);

    //     $this->gClient->setAccessToken(json_decode($user->access_token, true));

    //     if ($this->gClient->isAccessTokenExpired()) {

    //         // SAVE REFRESH TOKEN TO SOME VARIABLE
    //         $refreshTokenSaved = $this->gClient->getRefreshToken();

    //         // UPDATE ACCESS TOKEN
    //         $this->gClient->fetchAccessTokenWithRefreshToken($refreshTokenSaved);

    //         // PASS ACCESS TOKEN TO SOME VARIABLE
    //         $updatedAccessToken = $this->gClient->getAccessToken();

    //         // APPEND REFRESH TOKEN
    //         $updatedAccessToken['refresh_token'] = $refreshTokenSaved;

    //         // SET THE NEW ACCES TOKEN
    //         $this->gClient->setAccessToken($updatedAccessToken);

    //         $user->access_token = $updatedAccessToken;

    //         $user->save();
    //     }
    //     try {
    //         $fileMetadata = new Drive\DriveFile(array(
    //             'name' => 'photo.jpg'
    //         ));
    //         $content = file_get_contents('../public/Screenshot_1.png');
    //         $file = $service->files->create($fileMetadata, array(
    //             'data' => $content,
    //             'mimeType' => 'image/jpeg',
    //             'uploadType' => 'multipart',
    //             'fields' => 'id'
    //         ));
    //         printf("File ID: %s\n", $file->id);
    //         return $file->id;
    //     } catch (Exception $e) {
    //         echo "Error Message: " . $e;
    //     }
    // }
}
