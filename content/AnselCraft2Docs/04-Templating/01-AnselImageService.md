{
    "title": "Ansel Image Service"
}

Both `entry.myAnselField` and `craft.ansel.images` return an instance of the Ansel Image Service. In the case of an entry field, that service is pre-loaded with the properties that load up the images in that field. But regardless, the usage is the same.

<div class="CodeBlockTitle">Example</div>
```twig
{% for image in craft.ansel.images.all() %}
    <img src="{{ image.getAsset().getUrl() }}" alt="{{ image.title }}">
{% endfor %}
```

Like `craft.entries`, parameters can be chained so that you can use things like `skipCover`, `position(2)`, `limit(4)` and all those goodies.

<div class="CodeBlockTitle">Example</div>
```twig
{% for image in entry.myAnselField.skipCover().position(2).limit(4).all() %}
    <img src="{{ image.getAsset().getUrl() }}" alt="{{ image.title }}">
{% endfor %}
```
