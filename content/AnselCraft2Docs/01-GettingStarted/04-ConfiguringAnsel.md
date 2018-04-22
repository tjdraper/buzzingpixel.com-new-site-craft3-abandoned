{
    "title": "Configuring"
}

Ansel has a few settings you may want to look at before diving in to making your Ansel fields.

<img alt="Ansel Global Settings" src="/uploads-static/software/ansel-craft/documentation/ansel-craft-2-settings-page.png" srcset="/uploads-static/software/ansel-craft/documentation/ansel-craft-2-settings-page.png 1x, /uploads-static/software/ansel-craft/documentation/ansel-craft-2-settings-page-2x.png 2x">

### Global Settings

Ansel has a number of global settings you may wish to take advantage of. To access them, click on "Ansel" on Craft's Settings page.

<div class="Note">
    <div class="Note__Title">
        Note
    </div>
    <div class="Note__Body">
        <p>On applicable settings, you can override the settings in config files. In order to take advantage of this feature, you can create an <code>ansel.php</code> file in <code>/config</code> and return an array of settings.</p>
    </div>
</div>

#### Hide the Upload/Save directory instructions when setting up a new field?

Hide the instructions for how to use the Upload/Save location settings when setting up/editing Ansel fields.

The config override item is `'hideSourceSaveInstructions' => true`.

#### Default maximum quantity

Use this to set a default value for maximum quantity when creating new fields.

The config override item is `defaultMaxQty`.

#### Default image quality

Use this to set a default value for the image quality setting when creating new fields.

The config override item is `defaultImageQuality`.

#### Default force JPG setting

Use this to set newly created fields to default to forcing JPG.

The config override item is `defaultJpg`.

#### Default retina mode

Use this to set newly created fields to default to retina mode.

The config override item is `defaultRetina`.

#### Default display title field

Use this to set newly created fields to default to show the title field.

The config override item is `defaultShowTitle`.

#### Default require title field

Use this to set newly created fields to default to require the title field.

The config override item is `defaultRequireTitle`.

#### Default customize title label

Use this to set newly created fields to have a default value for the title label.

The config override item is `defaultTitleLabel`.

#### Default display caption field

Use this to set newly created fields to default to show the caption field.

The config override item is `defaultShowCaption`.

#### Default require caption field

Use this to set newly created fields to default to require the caption field.

The config override item is `defaultRequireCaption`.

#### Default customize caption label

Use this to set newly created fields to have a default value for the caption label.

The config override item is `defaultCaptionLabel`.

#### Default display cover field

Use this to set newly created fields to default to show the cover field.

The config override item is `defaultShowCover`.

#### Default require cover field

Use this to set newly created fields to default to require the cover field.

The config override item is `defaultRequireCover`.

#### Default customize cover label

Use this to set newly created fields to have a default value for the cover label.

The config override item is `defaultCoverLabel`.

### Config file only options

There are a couple of configuration options that can only be set in the config file.

#### optimizerShowErrors

Normally the optimizer for `jpegoptim`, `gifsicle`, and `optipng` will fail silently. However, it can sometimes be useful to know if something is going wrong — for instance, when you install the tools on your server and want to make sure they are working. If the optimizer is not able to find the tools or they return an error code when trying to optimize the image, when this config setting is set to true, the optimizer will throw an error for you to see.

`'optimizerShowErrors' => true;`

#### disableOptipng

Disables `optipng` optimization.

`'disableOptipng' => true;`

#### disableJpegoptim

Disables `jpegoptim` optimization.

`'disableJpegoptim' => true;`

#### disableGifsicle

Disables `gifsicle` optimization.

`'disableGifsicle' => true;`
