{
    "title": "Validation Result Class"
}

The Validation Result Class is returned by Treasury whenever applicable. It has two properties:

- `(bool) hasErrors`
- `(array) errors`

Here's an example of how Treasury uses this internally:

<div class="CodeBlockTitle">Example</div>
```php
// Run the upload
$result = ee('treasury:UploadAPI')
    ->locationHandle($this->locationModel->handle)
    ->filePath($this->saveData['filePath'])
    ->fileName($this->saveData['fileName'])
    ->title($this->saveData['title'])
    ->description($this->saveData['description'])
    ->addFile();

// Check if validation has errors
if ($result->hasErrors) {
    // Concatenate the errors
    $errors = '<ul><li>' . implode('</li><li>', $result->errors) . '</li></ul>';

    // Set errors
    ee('CP/Alert')->makeInline('upload_errors')
        ->asIssue()
        ->canClose()
        ->withTitle(lang('upload_errors'))
        ->addToBody($errors)
        ->defer();

    // Redirect and show error
    ee()->functions->redirect(
        ee('CP/URL', "addons/settings/treasury/upload/{$this->locationId}")
    );
}
```
