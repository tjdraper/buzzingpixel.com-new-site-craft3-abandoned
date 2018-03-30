// Make sure FAB is defined
window.FAB = window.FAB || {};

function runMain(F) {
    'use strict';

    if (! window.jQuery ||
        ! F.controller ||
        ! F.model
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
}

runMain(window.FAB);
