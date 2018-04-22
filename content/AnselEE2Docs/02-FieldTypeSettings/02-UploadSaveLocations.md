{
    "title": "Upload and Save Locations"
}

The first two settings for any Ansel field are very related and require a tiny bit of explanation.

The Upload directory is where source images are drawn from or uploaded to. It is meant to be a user facing directory — the one your users will see when they add an image to an Ansel field.

The save directory is where Ansel saves images the user crops or otherwise adds to the field. The end user should not ever need to see this directory. Ansel names the files with image IDs and timestamps for cache breaking purposes and so on when the user updates the images in any field.

<div class="Note">
    <div class="Note__Title">
        Note
    </div>
    <div class="Note__Body">
        <p>There are a few different approaches and ways of thinking about this. You could create a source and save location for each field and keep everything separate, or you could create one general upload location for all source images, and/or a save location for each field. Either approach has its merits. Or a third way is to create on General purpose directory, and one Ansel Save directory which is hidden from all content managers. This is the approach I (TJ) take.</p>
    </div>
</div>
