{
    "title": "Files API: Update File"
}

`ee('treasury:FilesAPI')->updateFile()`

This method lets you update the title and description of a file.

<div class="CodeBlockTitle">Example</div>
```php
$result = ee('treasury:FilesAPI')->updateFile(
    15, // Required. ID of the file to update
    'title', // Required. File title
    'description' // Optional. Description.
);
```

### Return Value

The `updateFile()` method returns a Treasury [Validation Result Class](#validation-result-class).
