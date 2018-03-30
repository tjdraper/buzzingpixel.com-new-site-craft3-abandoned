// Make sure FAB is defined
window.FAB = window.FAB || {};

function runNavScroll(F, W) {
    'use strict';

    if (! window.jQuery || ! F.controller) {
        setTimeout(function() {
            runNavScroll(F, W);
        }, 10);
        return;
    }

    F.controller.make('NavScroll', {
        scrollSwitch: 40,

        model: {
            isScrolled: 'bool'
        },

        init: function() {
            var self = this;
            var $W = $(W);
            var scrolledClass = self.$el.data('scrolledClass');

            self.model.onChange('isScrolled', function(val) {
                if (val) {
                    self.$el.addClass(scrolledClass);
                } else {
                    self.$el.removeClass(scrolledClass);
                }
            });

            $W.off('scroll.NavScroll');

            $W.on('scroll.NavScroll', function() {
                var pos = $W.scrollTop();

                var isScrolled = self.model.get('isScrolled');

                if (pos >= self.scrollSwitch && ! isScrolled) {
                    self.model.set('isScrolled', true);
                } else if (pos < self.scrollSwitch && isScrolled) {
                    self.model.set('isScrolled', false);
                }
            });
        }
    });
}

runNavScroll(window.FAB, window);
