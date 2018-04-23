{
    "title": "How the Extension Hook Works"
}

The Construct extension uses the [core template route] hook. When you load any URI in ExpressionEngine, the [core template route] hook is run.

Construct checks to see if there is a Node with routing enabled that matches the current URI and has a template associated with it. It also checks to see if the route is a match for any config file routes.

[core template route]: https://docs.expressionengine.com/latest/development/extension_hooks/global/core/index.html#core-template-route

<div class="Note">
    <div class="Note__Title">
        Note
    </div>
    <div class="Note__Body">
        <p>It is recommended that you completely disable the ExpressionEngine built-in Pages module since it also has to run queries to see if the current URI is a match for the page. The routing functionality of Construct is intended to replace the first party Pages module.</p>
    </div>
</div>
