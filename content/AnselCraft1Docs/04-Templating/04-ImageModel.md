{
    "title": "Image Model"
}

Ultimately, when your looping through the Image Criteria Model, or getting the `first` or `last` result, you will be using the Image Model. The image model has the following properties you can access.

<div class="CodeBlockTitle">Model</div>
```twig
{% set image = entry.myImageField.random(true).first() %}

{{ image.id }} {# Integer #}

{{ image.elementId }} {# Integer #}
{% set element = image.element %} {# \Craft\ElementCriteriaModel #}

{{ image.fieldId }} {# Integer #}
{% set field = image.field %} {# \Craft\FieldModel #}

{{ image.userId }} {# Integer #}
{% set user = image.user %} {# \Craft\UserModel of the user who added the row to the field #}

{{ image.assetId }} {# Integer #}
{% set image = image.asset %} {# \Craft\AssetFileModel of the manipulated asset for this image #}

{{ image.highQualAssetId }} {# Integer #}
{% set highQualImage = image.highQualityAsset %} {# \Craft\AssetFileModel of the highest possible quality of the manipulated image #}

{{ image.thumbAssetId }} {# Integer #}
{% set thumbImage = image.thumbAsset %} {# \Craft\AssetFileModel of the highest possible quality of the manipulated image #}

{{ image.originalAssetId }} {# Integer #}
{% set originalImage = image.originalAsset %} {# \Craft\AssetFileModel of the original un-manipulated image #}

{{ image.width }} {# Integer #}

{{ image.height }} {# Integer #}

{{ image.title }} {# String #}

{{ image.caption }} {# String #}

{{ image.cover }} {# Boolean #}

{{ image.position }} {# Integer #}

{{ image.disabled }} {# Boolean #}

{{ image.dateCreated }} {# \Craft\DateTime #}

{{ image.dateUpdated }} {# \Craft\DateTime #}
```
