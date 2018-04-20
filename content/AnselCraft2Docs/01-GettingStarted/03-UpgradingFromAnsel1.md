{
    "title": "Upgrading from Ansel 1.x"
}

### General requirements

Follow the update instructions for updating Craft CMS using the Craft CMS documentation. Once you have completed that, you can install Ansel. If you install Ansel via the command line with Composer, be sure to visit a CP page which will run some required schema updates.

You'll also probably need to do some template updating:

- `.all()` must be called to loop through ansel images (or use `.one()` to get a single image)
- `.first()` and `.find()` must be replaced with `.one()` and `.all()` respectively.
