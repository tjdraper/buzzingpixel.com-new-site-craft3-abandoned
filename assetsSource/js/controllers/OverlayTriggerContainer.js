// Make sure FAB is defined
window.FAB = window.FAB || {};

function runOverlayTriggerContainer(F, W) {
    'use strict';

    if (! window.jQuery || ! F.controller) {
        setTimeout(function() {
            runOverlayTriggerContainer(F, W);
        }, 10);
        return;
    }

    F.controller.make('OverlayTriggerContainer', {
        model: {},
        $overlay: null,

        init: function() {
            var self = this;

            self.$overlay = $(
                self.$el.find('.JSOverlayTriggerContainer__Template').html()
            );
        },

        renderOverlay: function() {
            var self = this;

            self.$siteWrapper.addClass(
                self.$siteWrapper.data('hasOverlayClass')
            );

            self.$siteWrapper.after(self.$overlay);

            self.$overlay.find('.JSOverlay__CloseButton').on('click', function() {
                self.removeOverlay();
            });

            $('body').on('keyup.' + self.model.guid, function(e) {
                if (e.keyCode !== 27) {
                    return;
                }

                self.removeOverlay();
            });

            self.$overlay.on(
                'submit.' + self.model.guid,
                '.JSOverlayForm__OnSubmitWait',
                function() {
                    var $form = $(this);

                    $form.hide();

                    self.$overlay.find('.JSOverlay__Waiting').show();
                }
            );
        },

        removeOverlay: function() {
            var self = this;

            self.$overlay.detach();

            self.$siteWrapper.removeClass(
                self.$siteWrapper.data('hasOverlayClass')
            );

            $('body').off('keyup.' + self.model.guid);

            self.$overlay.off('submit.' + self.model.guid);
        }
    });
}

runOverlayTriggerContainer(window.FAB, window);
