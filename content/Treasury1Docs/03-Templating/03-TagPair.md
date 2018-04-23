{
    "title": "Tag Pair"
}

`{my_field}{treasury:file_url}{/my_field}`

`{exp:treasury:files}{treasury:file_url}{/exp:treasury:files}`

The tag pair will loop through the matching images and make all variables available within the tag pair.

<div class="Note">
    <div class="Note__Title">
        Note
    </div>
    <div class="Note__Body">
        <p>Examples assume the default namespace of `treasury`.</p>
    </div>
</div>

<div class="CodeBlockTitle">Example</div>
```ee
{exp:treasury:files}
    {treasury:id}
    {treasury:site_id}
    {treasury:title}
    {treasury:location_id}
    {if treasury:is_image}This is an image{/if}
    {treasury:mime_type}
    {treasury:file_name}
    {treasury:extension}
    {treasury:file_size}
    {treasury:description}
    {treasury:uploaded_by_member_id}
    {treasury:upload_date}
    {treasury:modified_by_member_id}
    {treasury:modified_date}
    {treasury:height}
    {treasury:width}
    {treasury:file_url}
    {treasury:thumb_url}
    {treasury:index}
    {treasury:count}
    {treasury:total}
    {treasury:total_results}

    {if treasury:no_results}No Files Found{/if}
{/exp:treasury:files}
```
