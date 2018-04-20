// Make sure FAB is defined
window.FAB = window.FAB || {};

function runMobileDocsPagesMenu(F, W) {
    'use strict';

    if (! window.jQuery || ! F.controller) {
        setTimeout(function() {
            runMobileDocsPagesMenu(F, W);
        }, 10);
        return;
    }

    F.controller.make('MobileDocsPagesMenu', {
        menuBreakPoint: 900,

        model: {
            isActive: 'bool'
        },

        isMobile: true,

        events: {
            'click .JSMobileDocsPagesMenuActivator': function(e) {
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

            $(W).on('resize.MobileMenuWatch', function() {
                self.resizeResponder();
            });
        },

        resizeResponder: function() {
            var self = this;
            var windowIsDesktop = W.innerWidth >= self.menuBreakPoint;
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

            if (W.innerWidth >= F.menuBreakPoint) {
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
            $('.JSMobileDocsPagesMenu__List').slideDown(150);

            $('.JSMobileDocsPagesMenuActivator').each(function() {
                var $el = $(this);
                var activeClass = $el.data('activeClass');

                if (! activeClass) {
                    return;
                }

                $el.addClass(activeClass);
            });
        },

        deactivateMenu: function() {
            var $navList = $('.JSMobileDocsPagesMenu__List');

            $navList.slideUp(150, null, function() {
                $navList.attr('style', null);
            });

            $('.JSMobileDocsPagesMenuActivator').each(function() {
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

runMobileDocsPagesMenu(window.FAB, window);
