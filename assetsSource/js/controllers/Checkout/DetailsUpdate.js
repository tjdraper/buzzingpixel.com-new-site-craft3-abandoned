// Make sure FAB is defined
window.FAB = window.FAB || {};

function runDetailsUpdate(F) {
    'use strict';

    if (! window.jQuery || ! F.controller) {
        setTimeout(function() {
            runDetailsUpdate(F);
        }, 10);
        return;
    }

    F.controller.make('DetailsUpdate', {
        events: {
            'change .JSCheckoutForm__Input--UpdateWatch': function() {
                this.changeRespond();
            }
        },

        changeRespond: function() {
            var self = this;
            var $actionInput = self.$el.find('.JSCheckoutForm__ActionInput');

            $actionInput.val($actionInput.data('updateCartAction'));

            $.ajax({
                data: self.$el.serialize(),
                method: 'POST',
                success: function() {
                    F.triggerCartUpdated();
                }
            });
        }
    });
}

runDetailsUpdate(window.FAB);
