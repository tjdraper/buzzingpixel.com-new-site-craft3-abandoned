{
    "title": "Template Preferences"
}

Construct's Template Preferences are a way of associating a user friendly name with an ExpressionEngine template. Each Construct Template Preference is a one to one relationship with an EE template.

<img alt="Ansel Global Settings" src="/uploads-static/software/construct/documentation/control-panel/construct-template-preferences.png" srcset="/uploads-static/software/construct/documentation/control-panel/construct-template-preferences.png 1x, /uploads-static/software/construct/documentation/control-panel/construct-template-preferences-2x.png 2x">

There are two steps to enabling templates to be selected by nodes:

1. Create a template preference for the EE templates you would like to have available
2. Later when creating Trees, chose one or more Template Preferences to make available to nodes in that Tree (more on that later)

<div class="Note">
    <div class="Note__Title">
        Note
    </div>
    <div class="Note__Body">
        <p>Routing must be enabled to associate Template with Nodes.</p>
    </div>
</div>

### Ordering Template Preferences

When viewing your Template Preferences, you can drag and drop the order of the templates. This affects the order they are seen in when selecting them for use on a Node. After sorting the order of your templates via drag and drop, be sure to click the save button at the bottom of the form.

### Deleting Template Preferences

You can also delete one or more Template Preferences at a time. To delete Template Preferences, select the Delete checkbox for one or more templates and click the save button at the bottom of the form.

### Template Preferences Options

Template Preferences have learned a few new tricks in Construct 2. You can now designate channels a template can list entries from in addition to specifying a channel to make entries available on a one to one basis with the template.

And two new toggles for specifying the template as a listing template or a listing category template are here as well.

<img alt="Ansel Global Settings" src="/uploads-static/software/construct/documentation/control-panel/construct-template-preference.png" srcset="/uploads-static/software/construct/documentation/control-panel/construct-template-preference.png 1x, /uploads-static/software/construct/documentation/control-panel/construct-template-preference-2x.png 2x">

#### Construct Template Name

As you would expect, this is the friendly name of your template. It is the name users see when they select the template to associate it with a Node.

#### ExpressionEngine Template

This is the EE template for this Template Preference.

#### Channels for this template

Choose which channels to make entries available to this template from.

#### Listing channels for this template

Choose which channels can this template list entries from.

#### Listing entry template

Specify whether this template can be used for single entries (single entries from the listing channel).

#### Listing category template

Choose whether this template can be used to list category entries.
