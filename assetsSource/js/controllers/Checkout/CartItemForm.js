// Make sure FAB is defined
window.FAB = window.FAB || {};

function runCartItemForm(F) {
    'use strict';

    if (! window.jQuery || ! F.controller) {
        setTimeout(function() {
            runCartItemForm(F);
        }, 10);
        return;
    }

    F.controller.make('CartItemForm', {
        timer: 0,

        events: {
            'change .JSCartItemForm__Input': function(e) {
                this.changeRespond(e.currentTarget.value);
            },
            'keyup .JSCartItemForm__Input': function(e) {
                this.changeRespond(e.currentTarget.value);
            }
        },

        init: function() {
            var $el = this.$el;

            $el.addClass('Cart__ItemMeta--JsEnabled');

            $el.siblings('.JSCartItemTitle').addClass(
                'Cart__ItemTitle--JsEnabled'
            );
        },

        changeRespond: function(val) {
            var self = this;

            val = parseInt(val);

            if (isNaN(val) || val < 1) {
                return;
            }

            clearTimeout(self.timer);

            self.timer = setTimeout(function() {
                self.updateCart();
            }, 400);
        },

        updateCart: function() {
            var self = this;

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

runCartItemForm(window.FAB);
