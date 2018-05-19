// Make sure FAB is defined
window.FAB = window.FAB || {};

function runCartItemRemove(F) {
    'use strict';

    if (! window.jQuery || ! F.controller) {
        setTimeout(function() {
            runCartItemRemove(F);
        }, 10);
        return;
    }

    F.controller.make('CartItemRemove', {
        events: {
            'click .JSCartItem__Remove': function(e) {
                e.preventDefault();
                this.changeRespond($(e.currentTarget));
            }
        },

        changeRespond: function($el) {
            var self = this;

            $.ajax({
                url: $el.attr('href'),
                success: function() {
                    self.$el.remove();
                    F.triggerCartUpdated();
                }
            });
        }
    });
}

runCartItemRemove(window.FAB);
