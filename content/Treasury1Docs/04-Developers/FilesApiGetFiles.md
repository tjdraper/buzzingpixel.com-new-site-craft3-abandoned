{
    "title": "Files API: Get Files"
}

`ee('treasury:FilesAPI')->getFiles()`

The `getFiles()` method acts as a factory for a Treasury Collection of Treasury Files models representing Treasury files.

<div class="CodeBlockTitle">Example</div>
```php
$fileModelsCollection = ee('treasury:FilesAPI')->getFiles();
```

### Filtering

By default, the `getFiles()` method will get all files in the database ordered by upload date descending. But you can control what files are retrieved by filtering.

<div class="Note">
    <div class="Note__Title">
        Note
    </div>
    <div class="Note__Body">
        <p>All filters can use the the following comparisons:</p>
        <ul>
            <li>==</li>
            <li>!=</li>
            <li><</li>
            <li>></li>
            <li><=</li>
            <li>>=</li>
            <li>IN</li>
            <li>NOT IN</li>
         </ul>
    </div>
</div>

<div class="CodeBlockTitle">Example</div>
```php
$filesAPI = ee('treasury:FilesAPI')
    ->filter('id', 'IN', array(38, 39))
    ->filter('location_id', 2)
    ->filter('site_id', 2) // defaults to current site
    ->filter('file_name', 'my-file.jpg')
    ->filter('uploaded_by_member_id', 4)
    ->filter('modified_by_member_id', 2)
    ->filter('width', '>', 200)
    ->filter('height', '<', 300)
    ->search('My Search Key Words') // Searches title, mime_type, file_name, and description
    ->limit(4)
    ->offset(8)
    ->order('modified_date', 'asc') // second arg optional. Defaults to upload_date desc
    // Order by values: upload_date|modified_date|title|file_name|mime_type

$file = $filesAPI->getFirst();
$files = $filesAPI->getFiles();
$total = $filesAPI->getCount();
```
