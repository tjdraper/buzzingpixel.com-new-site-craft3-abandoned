{
    "title": "Examples"
}

<div class="CodeBlockTitle">A Field From an Entry</div>
```twig
{% for entry in craft.entries.section('mySection').limit(2) %}
    <h1>{{ entry.title }}</h1>
    <div class="Images">
        {% set images = entry.myImagesField.limit(2).coverFirst(true).all() %}

        {% if not images|length %}
            <div class="Images__NoResults">
                This gallery has no images at this time. Please check back later.
            </div>
        {% endif %}

        {% for image in images %}
            <div class="Images__Image">
                <img src="{{ image.getAsset.getUrl() }}" alt="{{ image.title|default(entry.title) }}">
                <div class="Images__ImageCaption">
                    {{ image.caption }}
                </div>
            </div>
        {% endfor %}
    </div>
{% endfor %}
```

<div class="CodeBlockTitle">Resizing an Image on-the-fly</div>
```twig
{% set image = craft.ansel.images.one() %}

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
{% for entry in craft.entries.section('mySection').limit(2).all() %}
    <h1>{{ entry.title }}</h1>
    <div class="Blocks">
        {% for block in entry.matrixField %}
            <h2 class="Blocks__Title">{{ block.galleryTitle }}</h2>
            <div class="Image">
            {% set images = block.myImagesField.limit(2).coverFirst(true).all() %}

            {% if not images|length %}
                <div class="Images__NoResults">
                    This gallery has no images at this time. Please check back later.
                </div>
            {% endif %}

            {% for image in images %}
                <div class="Images__Image">
                    <img src="{{ image.getAsset().getUrl() }}" alt="{{ image.title|default(entry.title) }}">
                    <div class="Images__ImageCaption">
                        {{ image.caption }}
                    </div>
                </div>
            {% endfor %}
        </div>
        {% endfor %}
    </div>
{% endfor %}
```
