<?php
namespace OWOW\LaravelDrive;

use File;
use Google_Client as Client;
use Google_Service_Drive as Service;
use Illuminate\Support\Facades\Input;
use OWOW\LaravelDrive\Exceptions\ConfigNotFoundException;

/**
 * A Laravel wrapper for Google Drive API.
 *
 * @package laravel-drive
 * @author Dees Oomens <dees@owow.io>
 */
class DriveAPI
{
    /**
     * The Google Client instance.
     *
     * @var Client;
     */
    private $client;

    /**
     * The Google Service instance.
     *
     * @var Service;
     */
    public $service;

    /**
     * The added Drive Files.
     *
     * @var array
     */
    public $files = [];

    /**
     * @var array
     */
    private $config = [];

    /**
     * DriveAPI constructor.
     * @param null $pathToConfig
     */
    public function __construct($pathToConfig = null)
    {
        $this->initialize($pathToConfig);
    }

    /**
     * Initialize the class.
     *
     * @param $pathToConfig
     * @throws ConfigNotFoundException
     */
    private function initialize($pathToConfig)
    {
        $config = $this->getConfig($pathToConfig);

        $client = new Client();
        $client->setAuthConfig($config);
        $client->addScope("https://www.googleapis.com/auth/drive");

        $this->setClient($client);
        $this->service = new Service($this->getClient());
    }

    /**
     * DriveAPI constructor for static method.
     *
     * @param null $pathToConfig
     * @return $this
     */
    public static function create($pathToConfig = null)
    {
        return new self($pathToConfig);
    }

    /**
     * Get the Drive API config.
     *
     * @param null $pathToConfig
     * @return mixed
     * @throws ConfigNotFoundException
     */
    public function getConfig($pathToConfig = null)
    {
        // Check if the config file already has been included.
        if (is_array($this->config) && count($this->config)) {
            return $this->config;
        }

        // Check if the config file exists and get the full path.
        if (($fullPath = $this->hasConfig($pathToConfig)) == false) {
            throw new ConfigNotFoundException;
        }

        return $this->setConfig(include $fullPath);
    }

    /**
     * Set the config array.
     *
     * @param array $config
     * @return array
     */
    public function setConfig(array $config)
    {
        return $this->config = $config;
    }

    /**
     * Check if the config file exists.
     *
     * @param $pathToConfig
     * @return bool|string
     */
    private function hasConfig($pathToConfig)
    {
        if (is_null($pathToConfig)) {
            $path = config_path('drive.php');
        } else {
            $path = app_path($pathToConfig);
        }

        return File::exists($path) ? $path : false;
    }

    /**
     * Create a URL to obtain user authorization.
     * The authorization endpoint allows the user to first
     * authenticate, and then grant/deny the access request.
     * 
     * @param string|array $scope The scope is expressed as an array or list of space-delimited strings.
     * @return string
     */
    public function authUrl($scope = null)
    {
        return $this->client->createAuthUrl($scope);
    }

    /**
     * Set the access token.
     *
     * @return array
     */
    public function setToken()
    {
        $token = $this->client->fetchAccessTokenWithAuthCode(Input::get('code'));
        $this->client->setAccessToken($token);

        return $this->client->getAccessToken();
    }

    /**
     * Create a new Drive File.
     *
     * @param array $data
     * @return DriveFile
     */
    public function newFile(array $data = [])
    {
        $this->files[] = $file = new DriveFile($data);
        return $file;
    }

    /**
     * Get the client instance.
     *
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set the client instance.
     *
     * @param Client $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }
}