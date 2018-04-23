{
    "title": "Locations API: Get Location By Handle"
}

`ee('treasury:LocationsAPI')->getLocationByHandle()`

The `getLocationByHandle()` method returns a Treasury Locations model representing the Treasury Location.

<div class="CodeBlockTitle">Example</div>
```php
$locationModel = ee('treasury:LocationsAPI')->getLocationByHandle('my-location');
```
