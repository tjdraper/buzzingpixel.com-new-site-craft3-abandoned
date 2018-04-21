{
    "title": "Image Criteria Model"
}

Working with Ansel in the Craft Twig environment will be very familiar to any users of Craft. Whether you're using something like `entry.myAnselField` or `craft.ansel.images` you're going to be using the Image Criteria Model which is very similar to Craft's Element Criteria Model in every meaningful way.

<div class="CodeBlockTitle">Example</div>
```twig
{% for image in craft.ansel.images %}
    <img src="{{ image.asset.url }}" alt="{{ image.title }}">
{% endfor %}
```

Like `craft.entries`, parameters can be chained, you can use things like `first`, `last`, `limit` and all those goodies.

<div class="CodeBlockTitle">Example</div>
```twig
{% for image in entry.myAnselField.limit(1).skipCover(true) %}
    <img src="{{ image.asset.url }}" alt="{{ image.title }}">
{% endfor %}
```
