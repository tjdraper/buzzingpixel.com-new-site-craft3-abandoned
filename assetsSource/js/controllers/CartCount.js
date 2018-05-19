// Make sure FAB is defined
window.FAB = window.FAB || {};

function runCartCount(F) {
    'use strict';

    if (! window.jQuery || ! F.controller) {
        setTimeout(function() {
            runCartCount(F);
        }, 10);
        return;
    }

    F.controller.make('CartCount', {
        init: function() {
            var self = this;

            self.updateCartCount();

            F.GlobalModel.onChange('cartUpdated', function() {
                self.updateCartCount();
            });
        },

        updateCartCount: function() {
            var self = this;

            $.ajax({
                url: '/ajax/cart/count',
                success: function(resp) {
                    if (resp.count < 1) {
                        return;
                    }

                    self.$el.text(resp.count).show();
                }
            });
        }
    });
}

runCartCount(window.FAB);
