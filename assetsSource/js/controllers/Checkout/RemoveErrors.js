// Make sure FAB is defined
window.FAB = window.FAB || {};

function runRemoveErrors(F) {
    'use strict';

    if (! window.jQuery || ! F.controller) {
        setTimeout(function() {
            runRemoveErrors(F);
        }, 10);
        return;
    }

    F.controller.make('RemoveErrors', {
        events: {
            'change .input': function(e) {
                this.removeError($(e.currentTarget));
            },
            'keyup .input': function(e) {
                this.removeError($(e.currentTarget));
            },
            'change .select': function(e) {
                this.removeError($(e.currentTarget));
            }
        },

        removeError: function($input) {
            var $parent = $input.closest('.input-parent');

            if (! $parent.length) {
                return;
            }

            $parent.find(':input').removeClass('input--has-error');
            $parent.find(':input').removeClass('select--has-error');
            $parent.find('.CheckoutForm__InputErrors').remove();
        }
    });
}

runRemoveErrors(window.FAB);
