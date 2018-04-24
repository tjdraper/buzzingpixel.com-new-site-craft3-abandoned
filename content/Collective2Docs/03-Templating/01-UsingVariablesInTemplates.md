{
    "title": "Using Variables in Templates"
}

Using Collective variables in your templates is pretty simple. All variables are early parsed and are available as `{collective:var_name}`. Note the namespace of `collective`. This keeps you from running into any conflicts. With the namespace, you know you are always getting a Collective variable and not something else specific to a channel entries loop or something like that.

<div class="Note">
    <div class="Note__Title">
        Remember
    </div>
    <div class="Note__Body">
        <p>The full template tag is available right under the variable name in the Control Panel if you are logged in as super admin. To select the entire tag, double click over the variable template tag.</p>
    </div>
</div>
