// Make sure FAB is defined
window.FAB = window.FAB || {};

function runCartPricingUpdate(F) {
    'use strict';

    if (! window.jQuery || ! F.controller) {
        setTimeout(function() {
            runCartPricingUpdate(F);
        }, 10);
        return;
    }

    F.controller.make('CartPricingUpdate', {
        init: function() {
            var self = this;

            F.GlobalModel.onChange('cartUpdated', function() {
                self.getCartPricing();
            });
        },

        getCartPricing: function() {
            var self = this;

            $.ajax({
                url: self.$el.data('cartPricingInfoUrl'),
                success: function(resp) {
                    self.updateDom(resp);
                }
            });
        },

        updateDom: function(resp) {
            var $submit = $('.JSCheckoutForm__SubmitPayment');

            $('.JSCheckoutForm__SubTotal').text(resp.subTotal);
            $('.JSCheckoutForm__Tax').text(resp.tax);
            $('.JSCheckoutForm__Total').text(resp.total);

            $submit.val($submit.data('valueTemplate').replace('{total}', resp.total));
        }
    });
}

runCartPricingUpdate(window.FAB);
