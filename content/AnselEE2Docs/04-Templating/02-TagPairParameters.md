{
    "title": "Tag Pair Parameters"
}

The following parameters are available to all tags:

<div class="CodeBlockTitle">Tag Pair Parameters</div>
```twig
image_id="104|105"
not_image_id="106|110"

site_id="2"
not_site_id="1"

file_id="2|3" // EE file id
not_file_id="18|27"

original_location_type="ee|assets" // Possible values: ee|assets|treasury
not_original_location_type="treasury|ee"

original_file_id="34|45"
not_original_file_id="45|56"

upload_location_type="assets|treasury" // Possible values: ee|assets|treasury
not_upload_location_type="ee|assets"

upload_location_id="34|45"
not_upload_location_id="45|56"

filename="my_file" // do not include extension
not_filename="foo"

extension="jpg"
not_extension="jpg"

original_extension="png"
not_original_extension="png"

filesize="182827"
filesize="< 182827"
filesize="> 182827"

original_filesize="182827"
original_filesize="< 182827"
original_filesize="> 182827"

width="300"
width="< 300"
width="> 300"

height="300"
height="< 300"
height="> 300"

title="my title|my other title"
not_title="foo|baz"

caption="my caption|my other caption"
not_caption="foo|baz"

member_id="23|24"
not_member_id="56|23"

position="2"
position="< 2"
position="> 2"

cover_only="true"
skip_cover="yes"
show_disabled="y"

namespace="my_namespace" // Access variables as {my_namespace:var}

limit="4"

offset="4"

order_by="date:desc|order:asc"

random="yes" // Overrides order_by parameter

cover_first="yes"

manipulations="true" // Include EE directory manipulations (requires extra queries)

host="https://cdn.domain.com/"
```

The following parameters are unique to the stand-alone image tag:

<div class="CodeBlockTitle">Additional stand-alone tag parameters</div>
```twig
source_id="32|33" // Usually the channel id, but could be low variables id
not_source_id="45|46"

content_id="34|36" // Usually the entry id, but could be low variables id
not_content_id="46|68"

content_type="channel|grid" // Possible values: channel|grid|blocks|low_variables
not_content_type="low_variables|channel"

field_id="23|26"
not_field_id="45|56"

row_id="32|33" // Grid or Blocks
not_row_id="444|745"

col_id="43|44" // Grid or Blocks
not_col_id="5|10"
```


