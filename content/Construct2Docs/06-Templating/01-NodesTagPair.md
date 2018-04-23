{
    "title": "Nodes Tag Pair"
}

The `{exp:construct:nodes}` tag pair is primarily how you will output menus with Construct.

<div class="CodeBlockTitle">Example</div>
```ee
{exp:construct:nodes tree_id="2"}
    {construct:node_name}
{/exp:construct:nodes}
```

<div class="CodeBlockTitle">Nodes Tag Pair Parameters</div>
```ee
tree_id="1"
namespace="my_namespace" {!-- default namespace is "construct" --}
max_depth="2" {!-- Limit the depth of nesting the tag will output --}
parent_id="{construct_route:node_id}" {!-- Get child nodes of parent --}
node_entry_id="103" {!-- Only nodes with specified entry id --}
direct_parent="{construct_route:node_id}"
node_slug="{segment_2}"
node_full_route="{segment_1}/{segment_2}"
nested="false"
menu_output_only="false"
node_entry_id_not_empty="true"
```

<div class="CodeBlockTitle">Nodes Tag Pair Variables</div>
```ee
{construct:node_id}
{construct:node_tree_id}
{construct:node_parent}
{construct:node_level}
{construct:node_name}
{construct:node_slug}
{construct:node_external_link}
{construct:node_full_route}
{construct:node_link}
{construct:node_routing}
{construct:node_pagination}
{construct:node_pagination_amount}
{construct:node_entry_id}
{construct:node_listing_channels}
{construct:node_output}
{construct:level_index}
{construct:level_count}
{construct:level_total_results}
{construct:index}
{construct:count}
{construct:total_results}
{construct:has_children}
{construct:children}
```

<div class="Note">
    <div class="Note__Title">
        Note
    </div>
    <div class="Note__Body">
        <p>Construct does not use a trailing slash on links by default. If you need for Construct to use a trailing slash for the link, use this config item in your ExpressionEngine config file:</p>

           <p><code>$config['construct_link_trailing_slash'] = true;</code></p>
    </div>
</div>

<div class="CodeBlockTitle">Count Variable Examples</div>
```ee
{if construct:level_count == construct:level_total_results}
    {!-- Do awesome stuff here! --}
{/if}
```

<div class="CodeBlockTitle">Has Children Example</div>
```ee
{if construct:has_children}
    This node has children!
{/if}
```

### About the `{construct:children}` tag

This variable is treated differently than other variables. Think of it as a marker, or a placeholder for where the children of the current node will be inserted (if they exist). All nodes are parsed through the same code between your tag pair. Once children are parsed, they are place where the `{construct:children}` marker/variable is at.

<div class="CodeBlockTitle">Example</div>
```ee
{exp:construct:nodes tree_id="2"}
    {if construct:level_count == 1}
    <ul>
    {/if}
        <li>
            <a href="/{construct:node_full_route}">
                {construct:node_name}
            </a>
            {construct:children}
        </li>
    {if construct:level_count == construct:level_total_results}
    </ul>
    {/if}
{/exp:construct:nodes}
```

For the sake of the length of example code, let's assume you have two nodes that would be output in this situation and the second node is a child of the first node. That output would look like this:

<div class="CodeBlockTitle">Example Output</div>
```ee
<ul>
    <li>
        <a href="/my/node/route">
            My Node Name
        </a>
        <ul>
            <li>
                <a href="/my/node/route/other">
                    My Second Node Name
                </a>
            </li>
        </ul>
    </li>
</ul>
```

That's simple, clean, and dry. It allows us to use the same markup for both levels of nodes AND it puts it in the right place because of the `{construct:children}` marker/tag, and it still leaves you completely in control.

But what if you want to have different markup for differing levels of nodes? Not a problem. That's where all those node level tags come in at. Just because we’re doing magic with the placement of node children doesn't mean we can’t still make use of ExpressionEngine’s template parser as we would with any other tag pair.

<div class="CodeBlockTitle">Example</div>
```ee
{exp:construct:nodes tree_id="2"}
    {if construct:node_level == 1}
        {if construct:level_count == 1}
        <ul>
        {/if}
            <li>
                <a href="/{construct:node_full_route}">
                    {construct:node_name}
                </a>
                {construct:children}
            </li>
        {if construct:level_count == construct:level_total_results}
        </ul>
        {/if}
    {if:elseif construct:node_level == 2}
        <div>
            <a href="/{construct:node_full_route}">
                {construct:node_name}
            </a>
        </div>
    {/if}
{/exp:construct:nodes}
```

<div class="CodeBlockTitle">Example Output</div>
```ee
<ul>
    <li>
        <a href="/my/node/route">
            My Node Name
        </a>
        <div>
            <a href="/my/node/route/other">
                My Second Node Name
            </a>
        </div>
    </li>
</ul>
```

You're in charge. You can go as simple or as crazy as you want. You can use the same markup for 3 or 4 levels, then use different markup for level 1. Or whatever you want. Be creative! That's what Construct is here for!
