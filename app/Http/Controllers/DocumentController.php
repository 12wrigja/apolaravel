<?php

namespace APOSite\Http\Controllers;

use APOSite\Http\Requests;
use APOSite\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    private $disk;
    protected $documents;
    protected $sDocuments;

    /**
     * DocumentController constructor.
     */
    public function __construct()
    {
        $this->disk = Storage::disk('local');
        $this->documents = Config::get('assets.documents.public');
        $this->sDocuments = Config::get('assets.documents.secured');
    }


    public function index()
    {
        return view('tools.document_list')->with('files', $this->listFilesForUser(LoginController::currentUser()));
    }

    public function getDocument($filename)
    {
        $unsecuredFilePath = $this->documents . $filename;
        $securedFilePath = $this->sDocuments . $filename;
        //First check to see if the file is publicly accessible
        //requested path has to have no slashes in it (must be in the root document directory)
        if (!strpos($filename, '/') && $this->disk->exists($unsecuredFilePath)) {
            return $this->buildFileResponse($unsecuredFilePath, $filename);
        } else {
            //You have to be signed in for this part.
            if (LoginController::currentUser() != null) {
                //We are logged in as someone. Therefore, they can access documents in the secured folder
                //, plus any documents that they might have access to as an exec member.
                if ($this->disk->exists($securedFilePath)) {
                    return $this->buildFileResponse($securedFilePath, $filename);
                }
            }
        }
        return redirect()->route('error_show', ['id' => 404]);
    }

    public function getOfficeDocument($office, $filename)
    {
        $user = LoginController::currentUser();
        if ($user != null && AccessController::isExecMember($user)) {
            //Check and see if the file is in the directories that are accessible to that user.
            $folderNames = AccessController::getAccessibleFoldersForUser($user);
            if (in_array($office, $folderNames)) {
                $filePath = $this->sDocuments . $office . '/' . $filename;
                if ($this->disk->exists($filePath)) {
                    return $this->buildFileResponse($filePath, $filename);
                }
            }
        }
        return redirect()->route('error_show', ['id' => 404]);
    }

    private function listFilesForUser(User $user = null)
    {
        $files = [];
        $files['public'] = $this->prepareFiles($this->disk->files($this->documents), $this->documents);
        if ($user != null) {
            $files['members'] = $this->prepareFiles($this->disk->files($this->sDocuments), $this->sDocuments);
            $folders = AccessController::getAccessibleFoldersForUser($user);
            foreach ($folders as $office => $folder) {
                $files[$office] = $this->prepareFiles($this->disk->files($this->sDocuments . $folder),
                    $this->sDocuments);
            }
        }
        return $files;
    }

    private function prepareFiles($files, $baseDir = '')
    {
        $collection = collect($files);
        $collection = $collection->filter(function ($filename) {
            $last = strripos($filename, '/');
            $nextChar = substr($filename, $last + 1, 1);
            return $nextChar != '.';
        });
        if ($baseDir != null) {
            $pattern = '#^' . $baseDir . "#";
            $collection = $collection->transform(function ($filename) use ($pattern) {
                return preg_replace($pattern, '', $filename);
            });
        }
        $collection = $collection->transform(function ($filepath) {
            $lastpos = strripos($filepath, '/');
            $filename = null;
            if ($lastpos === false) {
                $filename = $filepath;
                return ['fullpath' => $filepath, 'filename' => $filename];
            } else {
                $office = substr($filepath, 0, $lastpos);
                $filename = substr($filepath, $lastpos + 1);
                return ['fullpath' => $filepath, 'filename' => $filename, 'office' => $office];
            }

        });
        return $collection->toArray();
    }

    private function buildFileResponse($filepath, $filename)
    {
        $file = $this->disk->get($filepath);
        $mime = $this->getMimeType($filepath);
        $headers = array(
            'Content-type' => $mime,
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        );
        return response()->make($file, 200, $headers);
    }

    private function getMimeType($filepath)
    {
        $fullFilePath = config('filesystem.disks.local.root') . '/' . $filepath;
        $fullFilePath = escapeshellcmd($fullFilePath);
        $command = "file -b --mime-type -m /usr/share/misc/magic {$fullFilePath}";
        $mimeType = shell_exec($command);
        return trim($mimeType);
    }
}
