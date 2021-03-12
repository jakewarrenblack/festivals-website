<?php

class FileUpload
{



    public static function exists($key)
    {
        return isset($_FILES) && is_array($_FILES) &&
            //An error value of 4 means no file has been uploaded. The user didn't upload.
            //Doesn't mean something went wrong, just no upload.
            array_key_exists($key, $_FILES) && $_FILES[$key]['error'] !== 4;
    }

    private $key;
    private $destination;
    private $maxSize;
    private $allowedExtensions;
    private $overwrite;
    private $file;


    public function __construct($key, $destination = null)
    {
        //The key is the name of our file upload button.
        $this->key = $key;
        if ($destination == null) {

            //We've defined UPLOAD_DIR in our config.
            $this->destination = 'UPLOAD_DIR';
        } else {
            $this->destination = rtrim($destination, DIRECTORY_SEPARATOR);;
        }
        $this->maxSize = 1 * 1024 * 1024; // 1 MB
        $this->allowedExtensions = array("jpg", "jpeg", "png", "gif");
        $this->overwrite = TRUE;
        $this->file = null;

        $this->checkDestination();
        $this->checkFileUpload();
    }

    public function setMaxSize($size)
    {
        if (!is_int($size) || $size <= 0) {
            throw new Exception("Invalid argument: integer greater than zero expected!");
        }
        $this->maxSize = $size;
    }

    public function setAllowedExtensions($options)
    {
        if (!is_array($options)) {
            throw new Exception("Invalid argument: array expected!");
        }
        $this->allowedExtensions = $options;
    }

    public function setOverwrite($overwrite)
    {
        if (!is_bool($options)) {
            throw new Exception("Invalid argument: boolean expected!");
        }
        $this->overwrite = $overwrite;
    }

    private function checkDestination()
    {
        if (empty($this->destination)) {
            throw new Exception("Invalid destination folder name!");
        }
        //If destination doesn't exist, make it.
        if (!file_exists($this->destination)) {
            mkdir($this->destination);
        }
        if (!is_dir($this->destination)) {
            throw new Exception("Destination folder is not a directory!");
        } else if (!is_writable($this->destination)) {
            throw new Exception("Destination is not writable!");
        }
    }

    private function checkFileUpload()
    {
        if (!isset($_FILES) || !isset($_FILES[$this->key])) {
            throw new Exception("File not found");
            //$this->key is 'profile' from our upload button.
            //If the error code wasn't upload_err-ok, something has gone wrong.
        } else if ($_FILES[$this->key]['error'] !== UPLOAD_ERR_OK) {
            $errorCode = $_FILES[$this->key]['error'];
            $errorMessage = $this->errorCodeToMessage($errorCode);
            throw new Exception($errorMessage);
        }
    }

    private function getExtension($string)
    {
        $ext = "";
        try {
            $parts = explode(".", $string);
            $ext = strtolower($parts[count($parts) - 1]);
        } catch (Exception $ex) {
            $ext = "";
        }
        return $ext;
    }

    //We'll use this to generate our random image ID.
    private function getRandom()
    {
        return strtotime(date('Y-m-d H:i:s')) . uniqid();
    }

    private function errorCodeToMessage($code)
    {
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
                $message = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = "The uploaded file was only partially uploaded";
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = "No file was uploaded";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = "Missing a temporary folder";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $message = "Failed to write file to disk";
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = "File upload stopped by extension";
                break;
            default:
                $message = "Unknown upload error";
                break;
        }
        return $message;
    }

    public function get($saveAsFileName = null)
    {
        $originalFileName = $_FILES[$this->key]["name"];
        $mimeType = $_FILES[$this->key]["type"];
        $fileSize = $_FILES[$this->key]["size"];
        $tempFileName = $_FILES[$this->key]["tmp_name"];

        //Make sure it's an upload file for security reasons.
        if (!is_uploaded_file($tempFileName)) {
            throw new Exception("Illegal file upload!");
        }
        //Make sure our file isn't too big.
        if ($fileSize > $this->maxSize) {
            throw new Exception("Uploaded file exceeds max file size!");
        }
        $originalFileExt = $this->getExtension($originalFileName);
        if (!in_array($originalFileExt, $this->allowedExtensions)) {
            throw new Exception("File type not allowed!");
        }

        if ($saveAsFileName === null) {
            $this->file = $this->destination . "/" . $this->getRandom() . "." . $originalFileExt;
        } else {
            $this->file = $this->destination . "/" . $saveAsFileName;
        }

        $move_status = move_uploaded_file($tempFileName, $this->file);
        if (!$move_status) {
            throw new Exception("File cannot be moved!");
        }

        return $this->file;
    }

    public function delete()
    {
        if (file_exists($this->file)) {
            unlink($this->file);
            $this->file = null;
        }
    }
}
