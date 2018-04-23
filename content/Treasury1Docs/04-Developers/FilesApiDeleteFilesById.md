{
    "title": "Files API: Delete Files By ID"
}

`ee('treasury:FilesAPI')->deleteFilesById(array(2, 45))`

The `deleteFilesById()` method takes and array of Treasury file IDs to delete.

<div class="CodeBlockTitle">Example</div>
```php
$result = ee('treasury:FilesAPI')->deleteFilesById(array(2, 45));
```

### Return Value

The `deleteFilesById()` method returns a Treasury [Validation Result Class](#validation-result-class).
