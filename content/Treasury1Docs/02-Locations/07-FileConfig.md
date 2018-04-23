{
    "title": "File Config"
}

Treasury locations can also be controlled in your ExpressionEngine config file (version control ALL THE THINGS!).

Here is what the config looks like:

<div class="CodeBlockTitle">Example</div>
```php
$config['treasury'] = [
    'private_key_path' => '/var/user/.ssh/id_rsa',
    'locations' => [
        // Location handle
        'bzpxl-test-bucket' => [
            'name' => 'My Location', // Common to all location types
            'type' => 'amazon_s3', // local|amazon_s3|sftp|ftp
            'allowed_file_types'=> 'images_only', // images_only|all_file_types
            'url' => 'https://s3.amazonaws.com/mybucket/', // Location URL common to all locations types
            'path' => '', // Path on disk for local type only
            'access_key_id' => '******', // Amazon S3,
            'secret_access_key' => '******', // Amazon S3
            'bucket_region' => 'us-east-1', // Amazon S3 - must match a bucket region value for Amazon S3
            'subfolder' => 'mysubdirectory', // Amazon S3
            'server' => '', // Common to SFTP and FTP
            'username' => '', // Common to SFTP and FTP
            'password' => '', // Common to SFTP and FTP
            'private_key' => '', // SFTP
            'private_key_path' => '', // SFTP
            'use_config_private_key_path' => true, // SFTP
            'port' => '22', // Common to SFTP and FTP
            'remote_path' => '', // Common to SFTP and FTP
        ]
    ]
];
```
