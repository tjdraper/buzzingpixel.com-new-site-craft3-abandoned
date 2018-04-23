{
    "title": "Routing From Config"
}

Construct allows you to set up routes in your config file and set various variables, or run your own PHP functions. If the route matches a Node and you have set specific items (such as the entry ID), it will override that item for that Node and will not be available in the Control Panel to edit.

The config item is `$config['construct_routes]` and takes an array. Each array key is the route you wish to match.

<div class="CodeBlockTitle">Example</div>
```php
$config['construct_routes'] = array(
    ':before' => array(
        'logic' => function($routing) {
            $route->setGlobal('routing:my_var', 'my_var_value');
        }
    ),
    ':home' => array(
        'template' => 'site/_index'
        'entryId' => 2
    ),
    'blog/:pagination' => array(
        'template' => 'blog/_index',
        'listingEntryTemplate' => 'blog/_entry'
    )
    'news' => array(
        'logic' => function($routing) {
            // do stuff here
        }
    )
);
```
