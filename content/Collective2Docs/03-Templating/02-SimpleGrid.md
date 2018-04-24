{
    "title": "Simple Grid"
}

Though the Simple Grid fields are available as single tags, you will notice if you try to call one that they need a bit more processing so we need to use the tag pair.

<div class="CodeBlockTitle">Example</div>
```ee
{exp:collective:simple_grid variable="tiers"}
    {simple_grid:tier} - {simple_grid:amount}
{/exp:collective:simple_grid}
```

<div class="CodeBlockTitle">Simple Grid Tag Pair Parameters</div>
```ee
variable="var_name" {!-- Simple Grid variable name to process --}
namespace="my_namespace" {!-- Default namespace is simple_grid --}
```

<div class="CodeBlockTitle">Simple Grid Tag Pair Variables</div>
```ee
{simple_grid:field_short_name}
{simple_grid:index}
{simple_grid:count}
{simple_grid:total_results}
```
