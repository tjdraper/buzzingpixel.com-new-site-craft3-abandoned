{
    "title": "Criteria Model Methods"
}

<div class="CodeBlockTitle">Methods</div>
```twig
{% set count = craft.ansel.images.width('> 300').count() %} {# Count matching images #}

{% set total = craft.ansel.images.height('> 300').total() %} {# Get total matching criteria regardless of limit/offset #}

{% set image = craft.ansel.images.first() %} {# Get the first image that matches criteria #}

{% set image = craft.ansel.images.last() %} {# Get the absolute last image that matches criteria regardless of limit/offset #}

{% set images = craft.ansel.images.find() %} {# Find instructs the model to run the query now #}
{# Normally the query will be run when needed when you iterate over images, etc. #}
```
