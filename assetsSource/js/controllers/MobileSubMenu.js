// Make sure FAB is defined
window.FAB = window.FAB || {};

function runMobileSubMenu(F, W) {
    'use strict';

    var desktopBreakPoint = 1000;

    if (! window.jQuery || ! F.controller) {
        setTimeout(function() {
            runMobileSubMenu(F, W);
        }, 10);
        return;
    }

    F.controller.make('MobileSubMenu', {
        model: {
            isActive: 'bool'
        },

        isMobile: true,

        events: {
            'click .JSSubNav__Activator': function(e) {
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

            self.resizeResponder();

            $(W).on('resize.MobileSubMenuWatch', function() {
                self.resizeResponder();
            });
        },

        resizeResponder: function() {
            var self = this;
            var windowIsDesktop = W.innerWidth >= desktopBreakPoint;
            var modeIsMobile = self.isMobile;

            if (windowIsDesktop && modeIsMobile) {
                self.model.set('isActive', false);
                self.deactivateMenu();
            }

            self.isMobile = ! windowIsDesktop;
        },

        menuResponder: function() {
            var self = this;
            var state = self.model.get('isActive');

            if (W.innerWidth >= desktopBreakPoint) {
                if (self.model.get('isActive')) {
                    self.deactivateMenu();
                }

                return;
            }

            if (state) {
                self.activateMenu();
                return;
            }

            self.deactivateMenu();
        },

        activateMenu: function() {
            var self = this;

            self.$el.addClass(self.$el.data('subNavActiveClass'));

            self.$el.find('.JSSubNav__List').slideDown(150);
        },

        deactivateMenu: function() {
            var self = this;

            self.$el.removeClass(self.$el.data('subNavActiveClass'));

            self.$el.find('.JSSubNav__List').slideUp(150);
        }
    });
}

runMobileSubMenu(window.FAB, window);
