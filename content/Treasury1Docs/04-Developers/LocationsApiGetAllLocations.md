{
    "title": "Locations API: Get All Locations"
}

`ee('treasury:LocationsAPI')->getAllLocations()`

The `getAllLocations()` method returns a Treasury collection of Treasury Locations models representing Treasury Locations. An argument can be passed in to control the order and sorting of locations.

<div class="CodeBlockTitle">Example</div>
```php
$locationsCollection = ee('treasury:LocationsAPI')->getAllLocations('name:desc');
```
