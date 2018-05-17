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
}

runMain(window.FAB);
