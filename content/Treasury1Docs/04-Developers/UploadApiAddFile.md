{
    "title": "Upload API: Add File"
}

`ee('treasury:UploadAPI')->addFile()`

The `addFile()` method will upload the provided file and add it to the Treasury file manager and database.

Before you can call the `addFile` method, you must set:

- `locationHandle`
- `filePath`
- `fileName`

You can optionally set:

- `title`
- `description`

<div class="CodeBlockTitle">Example</div>
```php
$result = ee('treasury:UploadAPI')
    ->locationHandle('my-location')
    ->filePath('/path/to/file/on/disk.jpg')
    ->fileName('nameYouWantUploadedFileTohave.png')
    ->title('Optional Title')
    ->description('Optional Description')
    ->addFile();
```

### Return Value

The `addFile()` method returns a Treasury [Validation Result Class](#validation-result-class).
