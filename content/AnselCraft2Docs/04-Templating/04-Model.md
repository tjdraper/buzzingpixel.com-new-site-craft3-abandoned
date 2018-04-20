{
    "title": "Image Model"
}

Ultimately, when you're looping through the Image Criteria Model, or getting `one()` or `all()`, you will be using the Image Model. The image model has the following properties and methods you can access.

<div class="CodeBlockTitle">Model</div>
```twig
{% set image = entry.myImageField.random(true).one() %}

{{ image.id }} {# Integer #}

{{ image.elementId }} {# Integer #}

{{ image.fieldId }} {# Integer #}

{{ image.userId }} {# Integer #}
{% set user = image.getUser() %} {# \craft\elements\User of the user who added the row to the field #}

{{ image.assetId }} {# Integer #}
{% set imageAsset = image.getAsset() %} {# \craft\elements\Asset of the manipulated asset for this image #}

{{ image.highQualAssetId }} {# Integer #}
{% set highQualImageAsset = image.getHighQualAsset() %} {# \craft\elements\Asset of the highest possible quality of the manipulated image #}

{{ image.thumbAssetId }} {# Integer #}
{% set thumbImageAsset = image.getThumbAsset() %} {# \craft\elements\Asset of the image thumbnail #}

{{ image.originalAssetId }} {# Integer #}
{% set originalImage = image.getOriginalAsset() %} {# \craft\elements\Asset of the original un-manipulated image #}

{{ image.width }} {# Integer #}

{{ image.height }} {# Integer #}

{{ image.title }} {# String #}

{{ image.caption }} {# String #}

{{ image.cover }} {# Boolean #}

{{ image.position }} {# Integer #}

{{ image.disabled }} {# Boolean #}

{{ image.dateCreated }} {# \DateTime #}

{{ image.dateUpdated }} {# \DateTime #}

{{ image.uid }} {# String - the database row's unique identifier #}
```
