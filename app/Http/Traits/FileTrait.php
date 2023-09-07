<?php

namespace App\Http\Traits;

use App\Models\User;
use Google\Service\Drive;
use Exception;
use Illuminate\Support\Facades\Auth;

trait FileTrait
{
    public $gClient;

    function __construct()
    {

        $this->gClient = new \Google_Client();

        $this->gClient->setApplicationName(config('googleDrive.GOOGLE_DRIVE_APP_NAME')); // ADD YOUR AUTH2 APPLICATION NAME (WHEN YOUR GENERATE SECRATE KEY)
        $this->gClient->setClientId(config('googleDrive.GOOGLE_DRIVE_CLIENT_ID'));
        $this->gClient->setClientSecret(config('googleDrive.GOOGLE_DRIVE_CLIENT_SECRET'));
        $this->gClient->setRedirectUri(route('google.login'));
        $this->gClient->setDeveloperKey(config('googleDrive.GOOGLE_DRIVE_DEVELOPER_KEY'));
        $this->gClient->setScopes(config('googleDrive.GOOGLE_SCOPES'));
        $this->gClient->setAccessType(config('googleDrive.GOOGLE_ACCESS_TYPE'));
        $this->gClient->setApprovalPrompt(config('googleDrive.GOOGLE_APPROVAL_PROMPT'));
    }
    public function OAuth2()
    {
        $user_id = Auth::id();
        $user = User::find($user_id);

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
    }
    public function driveCreateFolder(string $folder_name)
    {
        $service = new \Google\Service\Drive($this->gClient);
        $this->OAuth2();
        try {
            $folderMetadata = new Drive\DriveFile(array(
                'name' => $folder_name,
                'mimeType' => 'application/vnd.google-apps.folder'
            ));
            $file = $service->files->create($folderMetadata, array(
                'fields' => 'id'
            ));
            // printf("Folder ID: %s\n", $file->id);
            return $file->id;
        } catch (Exception $e) {
            echo "Error Message: " . $e;
        }
    }
    public function driveCreateFolderInFolder(string $folder_name, string $parent_id)
    {
        $service = new \Google\Service\Drive($this->gClient);
        $this->OAuth2();
        try {
            $folderMetadata = new Drive\DriveFile(array(
                'name' => $folder_name,
                'mimeType' => 'application/vnd.google-apps.folder',
                'parents' => [$parent_id],
            ));
            $file = $service->files->create($folderMetadata, array(
                'fields' => 'id'
            ));
            // printf("Folder ID: %s\n", $file->id);
            return $file->id;
        } catch (Exception $e) {
            echo "Error Message: " . $e;
        }
    }
}
