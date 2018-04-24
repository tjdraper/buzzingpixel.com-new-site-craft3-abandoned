{
    "title": "Categories Tag Pair"
}

The `{exp:category_construct:categories}` tag pair is primarily how you will output categories with Category Construct.

<div class="CodeBlockTitle">Example</div>
```ee
{exp:category_construct:categories group_id="2"}
    {construct:cat_name}
{/exp:category_construct:categories}
```

<div class="CodeBlockTitle">Categories Tag Pair Parameters</div>
```ee
group_id="1"
namespace="my_namespace" {!-- default namespace is "construct" --}
max_depth="2" {!-- Limit the depth of nesting the tag will output --}
parent_id="24" {!-- Get child categories of parent --}
parent_id_with_children="2|4|6" (new in 2.1.0)
direct_parent="28"
cat_url_title="hunting"
cat_id="4"
entry_id="32"
show_empty="false"
nested="false"
channel_id="1|2"
status="open|custom_status"
entry_count="true"
```

<div class="CodeBlockTitle">Categories Tag Pair Variables</div>
```ee
{construct:cat_id}
{construct:group_id}
{construct:parent_id}
{construct:cat_level}
{construct:cat_name}
{construct:cat_url_title}
{construct:cat_url_path}
{construct:cat_description}
{construct:cat_image}
{construct:custom_field_name}
{construct:parent_l2:var_name} (new in 2.1.0)
{construct:entry_count}
{construct:count}
{construct:total_results}
{construct:level_count}
{construct:level_total_results}
{construct:has_children}
{construct:has_grandchildren}
{construct:children}
```

<div class="CodeBlockTitle">Entry Categories Example</div>
```ee
{exp:channel:entries channel="blog"}
    {title}
    {body}
    {exp:category_construct:categories entry_id="{entry_id}"}
        {construct:cat_name}
    {/exp:category_construct:categories}
{/exp:channel:entries}
```

<div class="CodeBlockTitle">Count Variable Examples</div>
```ee
{if construct:level_count == construct:level_total_results}
    {!-- Do awesome stuff here! --}
{/if}
```

<div class="CodeBlockTitle">Has Children Example</div>
```ee
{if construct:has_children}
    This category has children!
{/if}
```

<div class="CodeBlockTitle">Has Grandchildren Example</div>
```ee
{if construct:has_grandchildren}
    This category has grand children!
{/if}
```

### About the <code>{construct:children}</code> tag

This variable is treated differently than other variables. Think of it as a marker, or a placeholder for where the children of the current category will be inserted (if they exist). All categories are parsed through the same code between your tag pair. Once children are parsed, they are place where the `{construct:children}` marker/variable is at.

<div class="CodeBlockTitle">Example</div>
```ee
{exp:category_construct:categories group_id="2"}
    {if construct:level_count == 1}
    <ul>
    {/if}
        <li>
            <a href="/{construct:cat_url_path}">
                {construct:cat_name}
            </a>
            {construct:children}
        </li>
    {if construct:level_count == construct:level_total_results}
    </ul>
    {/if}
{/exp:category_construct:categories}
```

For the sake of the length of example code, let’s assume you have two categories that would be output in this situation and the second category is a child of the first category. That output would look like this:

<div class="CodeBlockTitle">Example Output</div>
```ee
<ul>
    <li>
        <a href="/my/category/path">
            My Category Name
        </a>
        <ul>
            <li>
                <a href="/my/category/path/other">
                    My Second Category Name
                </a>
            </li>
        </ul>
    </li>
</ul>
```

That's simple, clean, and dry. It allows us to use the same markup for both levels of categories AND it puts it in the right place because of the `{construct:children}` marker/tag, and it still leaves you completely in control.

But what if you want to have different markup for differing levels of categories? Not a problem. That's where all those category level tags come in at. Just because we’re doing magic with the placement of node children doesn't mean we can’t still make use of ExpressionEngine’s template parser as we would with any other tag pair.

<div class="CodeBlockTitle">Example</div>
```ee
{exp:category_construct:categories group_id="2"}
    {if construct:cat_level == 1}
        {if construct:level_count == 1}
        <ul>
        {/if}
            <li>
                <a href="/{construct:cat_url_path}">
                    {construct:cat_name}
                </a>
                {construct:children}
            </li>
        {if construct:level_count == construct:level_total_results}
        </ul>
        {/if}
    {if:elseif construct:cat_level == 2}
        <div>
            <a href="/{construct:cat_url_path}">
                {construct:cat_name}
            </a>
        </div>
    {/if}
{/exp:category_construct:categories}
```

<div class="CodeBlockTitle">Example Output</div>
```ee
<ul>
    <li>
        <a href="/my/category/path">
            My Category Name
        </a>
        <div>
            <a href="/my/category/path/other">
                My Second Category Name
            </a>
        </div>
    </li>
</ul>
```

You're in charge. You can go as simple or as crazy as you want. You can use the same markup for 3 or 4 levels, then use different markup for level 1. Or whatever you want. Be creative! That's what Category Construct is here for!
