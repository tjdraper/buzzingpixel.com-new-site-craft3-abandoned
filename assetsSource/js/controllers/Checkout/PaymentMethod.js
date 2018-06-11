// Make sure FAB is defined
window.FAB = window.FAB || {};

function runPaymentMethod(F) {
    'use strict';

    if (! window.jQuery || ! F.controller) {
        setTimeout(function() {
            runPaymentMethod(F);
        }, 10);
        return;
    }

    F.controller.make('PaymentMethod', {
        events: {
            'change .JSCheckoutForm__PaymentMethod': function(e) {
                this.paymentMethodChangeResponder(e.currentTarget.value);
            }
        },

        paymentMethodChangeResponder: function(val) {
            var self = this;

            if (val === 'addNew') {
                self.setUpAddNewCard();
                return;
            }

            self.setUpExistingCard();
        },

        setUpAddNewCard: function() {
            var self = this;
            var $firstSection = self.$el.find(
                '.JSCheckoutForm__Section--FirstSection'
            );
            var $existingCardItems = self.$el.find(
                '.JSCheckoutForm__ExistingCardItems'
            );
            var $newCardItems = self.$el.find('.JSCheckoutForm__NewCardItems');

            $firstSection.addClass($firstSection.data('addNewCardClass'));
            $existingCardItems.hide();
            $newCardItems.show();
        },

        setUpExistingCard: function() {
            var self = this;
            var $firstSection = self.$el.find(
                '.JSCheckoutForm__Section--FirstSection'
            );
            var $existingCardItems = self.$el.find(
                '.JSCheckoutForm__ExistingCardItems'
            );
            var $newCardItems = self.$el.find('.JSCheckoutForm__NewCardItems');

            $firstSection.removeClass($firstSection.data('addNewCardClass'));
            $existingCardItems.show();
            $newCardItems.hide();
        }
    });
}

runPaymentMethod(window.FAB);
