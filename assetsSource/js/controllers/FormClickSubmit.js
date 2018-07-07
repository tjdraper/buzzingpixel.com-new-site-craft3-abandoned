// Make sure FAB is defined
window.FAB = window.FAB || {};

function runFormClickSubmit(F, W) {
    'use strict';

    if (! window.jQuery || ! F.controller) {
        setTimeout(function() {
            runFormClickSubmit(F, W);
        }, 10);
        return;
    }

    F.controller.make('FormClickSubmit', {
        events: {
            'click .JSFormClickSubmit__Trigger': function(e) {
                e.preventDefault();
                this.$el.submit();
            }
        }
    });
}

runFormClickSubmit(window.FAB, window);
