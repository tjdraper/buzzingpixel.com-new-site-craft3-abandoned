{
    "title": "Criteria Model Parameters"
}

<div class="CodeBlockTitle">Parameters</div>
```twig
{% set image = craft.ansel.images %}

{% set image = image.id('12,43') %} {# Ansel image primary key #}
{% set image = image.notId('305,34') %}

{% set image = image.elementId('134,3456') %} {# The owning element ID (such as an entry) #}
{% set image = image.notElementId('3453,56') %}

{% set image = image.fieldId('2,3') %}
{% set image = image.notFieldId('5,6') %}

{% set image = image.userId('7,8') %}
{% set image = image.notUserId('4,3') %}

{% set image = image.assetId('10,4565') %}
{% set image = image.notAssetId('3,8') %}

{% set image = image.originalAssetId('12,4568') %}
{% set image = image.notOriginalAssetId('4,18') %}

{% set image = image.width(300) %}
{% set image = image.width('< 300') %}
{% set image = image.width('> 300') %}

{% set image = image.height(300) %}
{% set image = image.height('< 300') %}
{% set image = image.height('> 300') %}

{% set image = image.title('my title,my other title') %}
{% set image = image.notTitle('foo,baz') %}

{% set image = image.caption('my caption,my other caption') %}
{% set image = image.notCaption('foo,baz') %}

{% set image = image.coverOnly(true) %}
{% set image = image.skipCover(true) %}
{% set image = image.showDisabled(true) %}

{% set image = image.position(2) %}
{% set image = image.position('< 2') %}
{% set image = image.position('> 2') %}

{% set image = image.limit(4) %}

{% set image = image.offset(4) %}

{% set image = image.order('position desc, fieldId asc') %}

{% set image = image.random(true) %} {#  Overrides order parameter #}
```
