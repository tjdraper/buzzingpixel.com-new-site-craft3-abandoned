{
    "title": "Upload API: Add File"
}

`ee('treasury:UploadAPI')->uploadFile()`

The `uploadFile()` method uploads a file to the provided location, but it is not added to the Treasury File Manager or database. You are responsible for knowing about the file and keeping track of it. Basically, Treasury is acting as a conduit to get your file to it's selected location. You can use the Locations API to get the Locations Model and get the URL to the location for future display or retrieval of the file.

Before you can call the `uploadFile` method, you must set:

- `locationHandle`
- `filePath`
- `fileName`

<div class="CodeBlockTitle">Example</div>
```php
$result = ee('treasury:UploadAPI')
    ->locationHandle('my-location')
    ->filePath('/path/to/file/on/disk.jpg')
    ->fileName('nameYouWantUploadedFileTohave.png')
    ->uploadFile();
```

### Return Value

The `uploadFile()` method returns a Treasury [Validation Result Class](#validation-result-class).
