{
    "title": "Configuring"
}

Ansel has a few settings you may want to look at before diving in to making your Ansel fields.

<img alt="Ansel Global Settings" src="/uploads-static/software/ansel-ee/documentation/ansel-global-settings.png" srcset="/uploads-static/software/ansel-ee/documentation/ansel-global-settings.png 1x, /uploads-static/software/ansel-ee/documentation/ansel-global-settings-2x.png 2x">

### License Key

The first thing you will want to do is visit the License page and enter your license key from your purchase.

The license page can by located by clicking on "Ansel" from the list of Add-ons in the Add-on Manager, then clicking on the "License" link in the sidebar.

<div class="Note">
    <div class="Note__Title">
        Remember
    </div>
    <div class="Note__Body">
        <p>You will need a license for each of the sites/public domain names you install Ansel on.</p>
    </div>
</div>

### Global Settings

Ansel has a number of other global settings you may wish to take advantage of. To access them, click on "Ansel" from the list of Add-ons in the Add-on Manager.

<div class="Note">
    <div class="Note__Title">
        Note
    </div>
    <div class="Note__Body">
        <p>The following settings have config file overrides which you can use to keep your config in your config file.</p>
    </div>
</div>

#### Default host

This field is blank on new installs. If you wish all image URLs to be served from a CDN (for instance), you can enter a fully qualified URL here.

The config override item is `$config['ansel']['default_host']`.

#### Hide the Upload/Save directory instructions when setting up a new field?

Hide the instructions for how to use the Upload/Save directory settings when setting up/editing Ansel fields.

The config override item is `$config['ansel']['hide_source_save_instructions'] = true;`.

#### Default maximum quantity

Use this to set a default value for maximum quantity when creating new fields.

The config override item is `$config['ansel']['default_max_qty']`.

#### Default image quality

Use this to set a default value for the image quality setting when creating new fields.

The config override item is `$config['ansel']['default_image_quality']`.

#### Default force JPG setting

Use this to set newly created fields to default to forcing JPG.

The config override item is `$config['ansel']['default_jpg']`.

#### Default retina mode

Use this to set newly created fields to default to retina mode.

The config override item is `$config['ansel']['default_retina']`.

#### Default display title field

Use this to set newly created fields to default to show the title field.

The config override item is `$config['ansel']['default_show_title']`.

#### Default require title

Use this to set newly created fields to default to require the title field.

The config override item is `$config['ansel']['default_require_title']`.

#### Default customize title label

Use this to set newly created fields to have a default value for the title label.

The config override item is `$config['ansel']['default_title_label']`.

#### Default display caption field

Use this to set newly created fields to default to show the caption field.

The config override item is `$config['ansel']['default_show_caption']`.

#### Default require caption

Use this to set newly created fields to default to require the caption field.

The config override item is `$config['ansel']['default_require_caption']`.

#### Default customize caption label

Use this to set newly created fields to have a default value for the caption label.

The config override item is `$config['ansel']['default_caption_label']`.

#### Default display cover field

Use this to set newly created fields to default to show the cover field.

The config override item is `$config['ansel']['default_show_cover']`.

#### Default require cover

Use this to set newly created fields to default to require the cover field.

The config override item is `$config['ansel']['default_require_cover']`.

#### Default customize cover label

Use this to set newly created fields to have a default value for the cover label.

The config override item is `$config['ansel']['default_cover_label']`.

### Config file only options

There are a couple of configuration options that can only be set in the config file.

#### optimizerShowErrors

Normally the optimizer for `jpegoptim`, `gifsicle`, and `optipng` will fail silently. However, it can sometimes be useful to know if something is going wrong — for instance, when you install the tools on your server and want to make sure they are working. If the optimizer is not able to find the tools or they return an error code when trying to optimize the image, when this config setting is set to true, the optimizer will throw an error for you to see.

`$config['ansel']['optimizerShowErrors'] = true;`

#### disableOptipng

Disables `optipng` optimization.

`$config['ansel']['disableOptipng'] = true;`

#### disableJpegoptim

Disables `jpegoptim` optimization.

`$config['ansel']['disableJpegoptim'] = true;`

#### disableGifsicle

Disables `gifsicle` optimization.

`$config['ansel']['disableGifsicle'] = true;`

#### forceGD

Forces Ansel to use [GD](http://php.net/manual/en/book.image.php) image processing for manipulating images. Normally, Ansel will auto-detect if [ImageMagick](https://www.imagemagick.org) is installed/setup with PHP and use it for manipulating images. If for whatever reason you would like to force Ansel to use GD even though ImageMagick is available, make this setting `true`.

`$config['ansel']['forceGD'] = true;`
