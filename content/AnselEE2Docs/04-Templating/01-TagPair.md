{
    "title": "Tag Pair"
}

The tag pair is how you output Ansel images. Whether you are using the custom field tag within a Channel Entry tag pair, a Grid field tag pair, a Bloqs field tag pair, a Low Variables tag pair, or the stand alone tag pair, usage is almost identical across the tags. In fact, the only real difference is with the stand alone tag pair, which has just a few extra parameters available to it.

<div class="CodeBlockTitle">Example</div>
```ee
{exp:channel:entries channel="my_channel"}
    {!-- Number of images in field --}
    {my_ansel_field count="true"}

    {!-- Check if field has images --}
    {if "{my_ansel_field count='true'}" > 0}
        // Do stuff if field has images
    {/if}

    {!-- Output images --}
    {my_ansel_field}
        {img:url}
    {/my_ansel_field}

    {!-- Output images from a grid field --}
    {grid_field}
        {grid_field:my_ansel_field}
            {img:url}
        {/grid_field:my_ansel_field}
    {/grid_field}

    {!-- Output images from a blocks field --}
    {blocks_field}
        {my_block}
            {my_ansel_block_field}
                {img:url}
            {/my_ansel_block_field}
        {/my_block}
    {/blocks_field}
{/exp:channel:entries}

{!-- Output images from a Low Variables Ansel field --}
{exp:low_variables:pair var="my_ansel_var"}
    {img:url:resize width="500"}
{/exp:low_variables:pair}

{!-- Output images with the stand alone tag --}
{exp:ansel:images content_id="102" field_id="33"}
    {if img:no_results}
        // Do no results markup here
    {/if}
    {img:url:resize width="400"}
{/exp:ansel:images}
```
