{
    "title": "Ansel Image Service Methods"
}

<div class="CodeBlockTitle">Methods</div>
```twig
{% set count = craft.ansel.images.width('> 300').count() %} {# Total images (regardless of limit #}

{% set image = craft.ansel.images.one() %} {# Get the first image that matches #}

{% set images = craft.ansel.images.all() %} {# Get all matching images #}
```
