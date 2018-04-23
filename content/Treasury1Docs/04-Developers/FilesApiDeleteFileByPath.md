{
    "title": "Files API: Delete File By Path"
}

`ee('treasury:FilesAPI')->deleteFileByPath('my-location', 'file-name.zip')`

The `deleteFileByPath()` method takes a location handle and a filename and deletes that file.

<div class="CodeBlockTitle">Example</div>
```php
$result = ee('treasury:FilesAPI')->deleteFileByPath('my-location', 'file-name.zip');
```

### Return Value

The `deleteFileByPath()` method returns a Treasury [Validation Result Class](#validation-result-class).
