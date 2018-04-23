{
    "title": "Route Keys"
}

Use the route keys in your `construct_routes` array to match URI segments. Construct makes several special commonly used route keys available that run regex on your route behind the scene.

Each route key value should be an array.

#### `my/uri`

The basic principle is that you use the array keys to match the route.

#### `:before`

This route key runs before any other route allowing you to set defaults or other things.

#### `:home`

This route key matches the home page.

#### `:pagination`

Matches a pagination segment. So you might do something like `blog/:pagination`.

#### `:any`

Matches any segment.

#### `:all`

Matches all segments.

#### `:num`

Matches a numeric segment.

#### `:year`

Matches a four digit year.

#### `:month`

Matches a two digit month.

#### `:day`

Matches a two digit day.

### Custom Regex

Construct Routes are really just running regex against your current URI and you can include your own regex.

So for instance, instead of using `:day` or `:month`, you could instead do this: `blog/(\d{2})/(\d{2})`. That would be equivalent to `blog/:month/:day`. Of course in this case, that regex is built in with the special route keys in a much more readable way, but the ability to perform your own regex is there.
