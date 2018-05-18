// Make sure FAB is defined
window.FAB = window.FAB || {};

function runMain(F) {
    'use strict';

    if (! window.jQuery ||
        ! F.controller ||
        ! F.model ||
        ! window.Cleave
    ) {
        setTimeout(function() {
            runMain(F);
        }, 10);
        return;
    }

    var GlobalModelConstructor = F.model.make({
        cartUpdated: 'int'
    });

    F.GlobalModel = new GlobalModelConstructor();

    F.triggerCartUpdated = function() {
        F.GlobalModel.set('cartUpdated', F.GlobalModel.get('cartUpdated') + 1);
    };

    F.controller.construct('MobileMenu', {
        el: 'body'
    });

    $('.JSSubNav').each(function() {
        F.controller.construct('MobileSubMenu', {
            el: this
        });
        F.controller.construct('SubMenu', {
            el: this
        });
    });

    $('.JSNavBar').each(function() {
        F.controller.construct('NavScroll', {
            el: this
        });
    });

    $('.JSContactForm').each(function() {
        F.controller.construct('ContactForm', {
            el: this
        });
    });

    if ($('.JSDocsPage').length) {
        F.controller.construct('MobileDocsPagesMenu', {
            el: 'body'
        });

        F.controller.construct('DocsSwitcherMenu', {
            el: 'body'
        });
    }

    if ($('pre').length) {
        F.controller.construct('CodeHighlighting');
    }

    $('.JSCartCount').each(function() {
        F.controller.construct('CartCount', {
            el: this
        });
    });

    $('.JSCreditCardNumber').each(function() {
        new window.Cleave(this, {
            creditCard: true
        });
    });

    $('.JSCheckoutForm').each(function() {
        F.controller.construct('CheckoutStateProvince', {
            el: this
        });
        F.controller.construct('DetailsUpdate', {
            el: this
        });
        F.controller.construct('CartPricingUpdate', {
            el: this
        });
    });
}

runMain(window.FAB);
