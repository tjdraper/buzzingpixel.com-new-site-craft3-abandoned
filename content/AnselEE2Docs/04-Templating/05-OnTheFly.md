{
    "title": "On the Fly Cropping and Resizing"
}

Ansel can crop and resize images on the fly. Doing so is very efficient because the cropped/resized image is cached after the first request for it is made. Any request for that cropped/resized image thereafter comes straight from the cache on disk.

Cropping/resizing is available to the `{img:url}` variable.

<div class="CodeBlockTitle">On the Fly Cropping/Resizing parameters</div>
```ee
width="400"
height="100"
crop="true"
background="d34747"
force_jpg="true"
quality="80"
scale_up="true"
cache_time="86400" // Defaults to forever
```

<div class="CodeBlockTitle">Example</div>
```ee
{img:url:resize
    width="400"
    height="100"
    crop="true"
    background="d34747"
    force_jpg="true"
    quality="80"
    scale_up="true"
}
```
