{
    "title": "Locations API: Remove Location"
}

`ee('treasury:LocationsAPI')->removeLocation()`

Removes a location.

<div class="CodeBlockTitle">Example</div>
```php
$locationModel = ee('treasury:LocationsAPI')->removeLocation('my-location');
```

### Return Value

The `removeLocation()` method returns a Treasury [Validation Result Class](#validation-result-class).
