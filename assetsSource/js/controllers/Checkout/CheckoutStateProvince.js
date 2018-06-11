// Make sure FAB is defined
window.FAB = window.FAB || {};

function runCheckoutStateProvince(F) {
    'use strict';

    if (! window.jQuery || ! F.controller) {
        setTimeout(function() {
            runCheckoutStateProvince(F);
        }, 10);
        return;
    }

    F.controller.make('CheckoutStateProvince', {
        events: {
            'change .JSCheckoutForm__CountryInput': function(e) {
                this.countryChangeResponder(e.currentTarget.value);
            }
        },

        countryChangeResponder: function(countryShortCode) {
            var self = this;

            if (countryShortCode === 'US') {
                self.setStateSelect();
                return;
            }

            self.setStateProvinceInput();
        },

        setStateSelect: function() {
            var self = this;

            self.$el.find('.JSCheckoutForm__StateProvinceLabel').replaceWith(
                $('#JSCheckoutForm__StateSelect').html()
            );
        },

        setStateProvinceInput: function() {
            var self = this;

            self.$el.find('.JSCheckoutForm__StateProvinceLabel').replaceWith(
                $('#JSCheckoutForm__StateProvince').html()
            );
        }
    });
}

runCheckoutStateProvince(window.FAB);
