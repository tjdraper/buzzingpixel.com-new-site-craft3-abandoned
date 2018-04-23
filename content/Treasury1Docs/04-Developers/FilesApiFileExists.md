{
    "title": "Files API: File Exists"
}

`ee('treasury:FilesAPI')->fileExists('my-location', 'file-name.png')`

The `fileExists()` method takes a location handle and a filename and checks if the file exists.

<div class="CodeBlockTitle">Example</div>
```php
$filesExists = ee('treasury:FilesAPI')->fileExists('my-location', 'file-name.zip');
```

### Return Value

The `fileExists()` method returns a boolean.
