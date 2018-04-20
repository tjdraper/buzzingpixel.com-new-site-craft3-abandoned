// Make sure FAB is defined
window.FAB = window.FAB || {};

function runDocsSwitcherMenu(F, W) {
    'use strict';

    if (! window.jQuery || ! F.controller) {
        setTimeout(function() {
            runDocsSwitcherMenu(F, W);
        }, 10);
        return;
    }

    F.controller.make('DocsSwitcherMenu', {
        model: {
            isActive: 'bool'
        },

        events: {
            'click .JSDocsSwitcherMenuActivator': function(e) {
                var self = this;

                e.preventDefault();

                self.model.set('isActive', ! self.model.get('isActive'));
            }
        },

        init: function() {
            var self = this;

            self.model.onChange('isActive', function() {
                self.menuResponder();
            });
        },

        menuResponder: function() {
            var self = this;
            var state = self.model.get('isActive');

            if (state) {
                self.activateMenu();
                return;
            }

            self.deactivateMenu();
        },

        activateMenu: function() {
            $('.JSDocsSwitcherMenu__List').slideDown(150);

            $('.JSDocsSwitcherMenuActivator').each(function() {
                var $el = $(this);
                var activeClass = $el.data('activeClass');

                if (! activeClass) {
                    return;
                }

                $el.addClass(activeClass);
            });
        },

        deactivateMenu: function() {
            var $navList = $('.JSDocsSwitcherMenu__List');

            $navList.slideUp(150, null, function() {
                $navList.attr('style', null);
            });

            $('.JSDocsSwitcherMenuActivator').each(function() {
                var $el = $(this);
                var activeClass = $el.data('activeClass');

                if (! activeClass) {
                    return;
                }

                $el.removeClass(activeClass);
            });
        }
    });
}

runDocsSwitcherMenu(window.FAB, window);
