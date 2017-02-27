<?php
namespace OWOW\LaravelDrive;

use Google_Service_Drive_DriveFile as File;

class DriveFile
{
    /**
     * @var File
     */
    public $file;

    public function __construct(array $data)
    {
        $this->file = new File($data);
    }

    /**
     * Return the File instance.
     *
     * @return File
     */
    public function getData()
    {
        return $this->file;
    }
}