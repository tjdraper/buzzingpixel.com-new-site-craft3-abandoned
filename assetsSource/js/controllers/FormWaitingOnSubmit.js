// Make sure FAB is defined
window.FAB = window.FAB || {};

function runFormWaitingOnSubmit(F) {
    'use strict';

    if (! window.jQuery || ! F.controller) {
        setTimeout(function() {
            runFormWaitingOnSubmit(F);
        }, 10);
        return;
    }

    F.controller.make('FormWaitingOnSubmit', {
        events: {
            submit: function(e) {
                var $form = $(e.currentTarget);
                var $siteWrapper = $('.JSSiteWrapper');
                var $overlay = $form.find('.JSFormShowWaitingOnSubmit__Overlay');
                $siteWrapper.after($overlay);
                $overlay.show();
                $siteWrapper.addClass($siteWrapper.data('hasOverlayClass'));
            }
        }
    });
}

runFormWaitingOnSubmit(window.FAB);
