{
    "title": "Get Total"
}

Sometimes you would like to display the total number of images in a field. Ansel makes this really easy with a parameter on the custom field tag:

<div class="CodeBlockTitle">Example</div>
```ee
{exp:channel:entries channel="my_channel"}
    {my_ansel_field count="true"}
{/exp:channel:entries}
```
