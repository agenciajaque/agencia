<?php
/* --------------------------------------------------------------------------------------
 *
 * Config file for the LaravelDrive package.
 *
 * -------------------------------------------------------------------------------------- */

return [
    "client_id" => env('GOOGLE_DRIVE_KEY', 'yourkeyoridfortheservice'),
    "project_id" => "owow-pitch",
    "auth_uri" => "https://accounts.google.com/o/oauth2/auth",
    "token_uri" => "https://accounts.google.com/o/oauth2/token",
    "auth_provider_x509_cert_url" => "https://www.googleapis.com/oauth2/v1/certs",
    "client_secret" => env('GOOGLE_DRIVE_SECRET', 'yoursecretfortheservice'),
    "redirect_uris" => [
        env('GOOGLE_DRIVE_REDIRECT_URI', 'http://localhost'),
        // Other URI's ..
    ],
    "javascript_origins" => [
        // Your javascript origins.
        "http://localhost",
    ],
];