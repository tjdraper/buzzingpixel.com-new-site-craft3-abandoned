{
    "title": "File Picker API"
}

`ee('treasury:FilePicker')->make()`

The File Picker API lets you get a link or a URL to a file picker modal.

### `make()`

Takes one optional argument of the location handle you would like the File Picker to use and returns the Treasury FilePicker service. The FilePicker service has the following methods:

#### `make()->setlocation()`

Set the location handle for the location you would like to use (defaults to all).

#### `make()->getUrl()`

Gets the URL to the location modal.

<div class="Note">
    <div class="Note__Title">
        Note
    </div>
    <div class="Note__Body">
        <p>In order for Treasury to be able to instantiate a modal off of this URL, the link you build will need to have the class `js-treasury-filepicker`.</p>
    </div>
</div>

#### `make()->getLink()`

Takes one optional argument of the text you would like to use for the `<a>` tag.

This method returns the Treasury `FilePicker\Link` service which you can use to build an HTML anchor link. The following methods are available from the `FilePicker\Link` service:

##### `make()->getLink()->setAttribute($key, $val)`

Allows you to add attributes to the `<a>` tag.

<div class="CodeBlockTitle">Example</div>
```php
$link = ee('treasury:FilePicker')->make('my-location')
    ->getLink('Click Me')
    ->setAttribute('class', 'my-button');
```

##### `make()->getLink()->addAttributes(array())`

Allows you to add multiple attributes to the `<a>` tag at once.

<div class="CodeBlockTitle">Example</div>
```php
$link = ee('treasury:FilePicker')->make('my-location')
    ->getLink('Click Me')
    ->addAttributes(array(
        'class' => 'my-button',
        'id' => 'my-id'
    ));
```

##### `make()->getLink()->setText('Click Me')`

Set the text of the `<a>` tag.

<div class="CodeBlockTitle">Example</div>
```php
$link = ee('treasury:FilePicker')->make('my-location')
    ->getLink()
    ->setText('Click Me');
```

##### `make()->getLink()->setHtml($html)`

Set the HTML content of the `<a>` tag.

<div class="CodeBlockTitle">Example</div>
```php
$link = ee('treasury:FilePicker')->make('my-location')
    ->getLink()
    ->setHtml('my html');
```

##### `make()->getLink()->render()`

While the magic `__toString()` method will usually run the render method when needed, it may sometimes be necessary to manually run the render method to get your rendered HTML `<a>` tag. Here's a full example:

<div class="CodeBlockTitle">Example</div>
```php
$link = ee('treasury:FilePicker')->make('my-location')
    ->getLink('Click Me')
    ->setAttribute('class', 'my-button')
    ->render();
```

### The JavaScript Side

The button opens an EE modal and you can select a file, but you need to do something with it after it is selected. In order to do that, you need to set a callback on your button.

#### `$('.my-button-el').TreasuryFilePicker()`

Use the `TreasuryFilePicker` jQuery plugin to set a callback function to use for your button instance.

<div class="CodeBlockTitle">Example</div>
```javascript
$('.my-button-el').TreasuryFilePicker({
    callback: function(file) {
        console.log(file);
    }
});
```

The first argument is an object with all the properties of the file, plus any of those properties that don't match EE's file object translated.
