// Make sure FAB is defined
window.FAB = window.FAB || {};

function runOverlayTriggerContainerWatch(F, W) {
    'use strict';

    if (! window.jQuery || ! F.controller) {
        setTimeout(function() {
            runOverlayTriggerContainerWatch(F, W);
        }, 10);
        return;
    }

    F.controller.make('OverlayTriggerContainerWatch', {
        events: {
            'click .JSOverlayTriggerContainer__Trigger': function(e) {
                var self = this;
                var $container = $(e.currentTarget).closest('.JSOverlayTriggerContainer');
                var model = $container.data('model');

                e.preventDefault();

                if (! model) {
                    model = F.controller.construct('OverlayTriggerContainer', {
                        el: $container,
                        $siteWrapper: self.$el
                    });

                    $container.data('model', model);
                }

                model.renderOverlay();
            }
        }
    });
}

runOverlayTriggerContainerWatch(window.FAB, window);
