{
    "title": "Editing Nodes"
}

Nodes are menu items/pages within a tree. To add or edit Nodes for a Tree, select the Tree in the left had sidebar. From there you can either edit existing nodes by click on the pencil edit icon to the right of a node, or you can add a new node by clicking the blue Add New Node button.

To delete nodes, select the checkbox on the very right-most side of the node, at the bottom of the form, options will appears that will allow the deletion of the selected Node(s).

<div class="Note">
    <div class="Note__Title">
        Note
    </div>
    <div class="Note__Body">
        <p>You can also use the select box at the very top right of the form to select all Nodes.</p>
        <p>The "select all" checkbox at the top of the form selects all nodes <strong>whether they are visible or not</strong>.</p>
    </div>
</div>

### Nested Nodes

When you visit a Tree page, you will only see the top level nodes initially. If there are any nested nodes, they are collapsed. To see these nested nodes, click the triangle next to the Node name to expand sub nodes.

### View pages/external link

You can always view the resource the Node points to by clicking the link to the right of the Node's name.

### Node Information

Other information about the Node is available on the lower line under the name of the node such as its ID, slug, whether it has been set to show up in the menu, and whether it creates a page.

### Node Options

When adding or editing a Node, there are a number of options available to you.

#### Name

Give this Node a name. Typically you would use this in the menu output (via template tags).

#### Slug

The slug is used to compose the URLs and full paths of the Node. If the node is on the top level, the full path and the slug will be the same. However, if you the node is nested under another node, Construct builds the path based on the slugs. For instance, if a Node with the slug "our-ceo" was nested under a Node with the slug "about", the full path of the Node would be "about/our-ceo".

#### External Link

If you need the menu item of your Node to point to an external link, you can use this field (you will need to account for this with your template tags).

#### Show in Menu

Choose whether to show this Node in the menu output (this can be overridden with tag parameters as needed).

### Node Page Tools

When Construct's Routing is enabled, Nodes will have a section in their options called "Page Tools." With these options you can create pages.

#### Create Page

Choose whether or not this Node should create a Page (or just be a menu item).

#### Page Template

When you set the Create Page toggle to "Create", the "Page template" option will appear. Any Templates you have made available to the Tree will be available here.

<div class="Note">
    <div class="Note__Title">
        Note
    </div>
    <div class="Note__Body">
        <p>You must choose a template in order for the page to be created. If you choose to Create a Page with the toggle, but do not choose a template, no page will actually be created.</p>
    </div>
</div>

### Entry Listing Options

Here is where some of Construct's new tricks come into play. When you select a template that has channels available for listing, the new "Entry Listing Options" section will appear.

#### Listing channel(s)

Based on the listing channels you have made available to the template, one or more channels can be chosen here to list entries from.

#### Pagination

Once you have chosen one or more channels, you can chose whether or not the listing should be paginated. If you choose to paginate, you can set the amount per page (Construct defaults to 10).

#### Listing entry template

If you have made any templates available to list single entries from the chosen listing channel(s), you can choose one of them here to display single entries from your listing channel. When you do so, entries will be available as `/path-to-node/entry_url_title` and will be displayed using the template you selected.

#### Listing category template

If you have made any templates available to list categories from the chosen listing channel(s), you can choose one of them here to display category entries from your listing channel. Category pages will be available as `/path-to-node/category/cat_url_title`.

#### Simple Nodes (menu creation only)

As referenced at the top of this page in the settings segment, using Construct to build menus only is a perfectly viable use of Construct as it is very powerful for doing just that. Construct only shows the user what they need to see whenever possible. So if you have disabled Construct's routing option in settings. Construct will show a very minimal Node editing screen so as to keep things very user friendly.
