{
    "title": "Image Model"
}

<div class="CodeBlockTitle">A Field From an Entry</div>
```twig
{% for entry in craft.entries.section('mySection').limit(2) %}
    <h1>{{ entry.title }}</h1>
    <div class="images">
        {% set images = entry.myImagesField.limit(2).coverFirst(true) %}
        
        {% if not images.count %}
            <div class="images__no-results">
                This gallery has no images at this time. Please check back later.
            </div>
        {% endif %}

        {% for image in entry.myImagesField.limit(2).coverFirst(true) %}
            <div class="images__image">
                <img src="{{ image.asset.url }}" alt="{{ image.title|default(entry.title) }}">
                <div class="images__image-caption">
                    {{ image.caption }}
                </div>
            </div>
        {% endfor %}
    </div>
{% endfor %}
```

<div class="CodeBlockTitle">Resizing an Image on-the-fly</div>
```twig
{% set image = craft.ansel.images.first() %}

{% set imageTransform = {
    mode: 'crop',
    width: 600,
    quality: 80,
    position: 'Center-Center'
} %}

<img src="{{ image.highQualityAsset.getUrl(imageTransform) }}" alt="{{ image.title }}">
```

<div class="CodeBlockTitle">Ansel in a Matrix field</div>
```twig
{% for entry in craft.entries.section('mySection').limit(2) %}
    <h1>{{ entry.title }}</h1>
    <div class="blocks">
        {% for block in entry.matrixField %}
            <h2 class="blocks__title">{{ block.galleryTitlie }}</h2>
            <div class="images">
            {% set images = block.myImagesField.limit(2).coverFirst(true) %}
            
            {% if not images.count %}
                <div class="images__no-results">
                    This gallery has no images at this time. Please check back later.
                </div>
            {% endif %}

            {% for image in entry.myImagesField.limit(2).coverFirst(true) %}
                <div class="images__image">
                    <img src="{{ image.asset.url }}" alt="{{ image.title|default(entry.title) }}">
                    <div class="images__image-caption">
                        {{ image.caption }}
                    </div>
                </div>
            {% endfor %}
        </div>
        {% endfor %}
    </div>
{% endfor %}
```
