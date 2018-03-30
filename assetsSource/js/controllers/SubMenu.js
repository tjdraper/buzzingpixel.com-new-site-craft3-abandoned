// Make sure FAB is defined
window.FAB = window.FAB || {};

function runSubNav(F, W) {
    'use strict';

    var menuAnimationTime = 150;
    var SubNavModelConstructor;
    var SubNavModel;

    if (! window.jQuery || ! F.controller) {
        setTimeout(function() {
            runSubNav(F, W);
        }, 10);
        return;
    }

    SubNavModelConstructor = F.model.make({
        currentlyActiveGuid: 'string'
    });
    SubNavModel = new SubNavModelConstructor();

    $('.JSSubNav__HasNoSubMenu').on('mouseenter', function() {
        SubNavModel.set('currentlyActiveGuid', '');
    });

    F.controller.make('SubMenu', {
        model: {
            subNavIsActive: 'bool',
            mode: 'string'
        },

        isMobile: true,
        mouseLeaveTimer: 0,

        events: {
            mouseenter: function() {
                var self = this;

                if (W.innerWidth < F.menuBreakPoint) {
                    return;
                }

                clearTimeout(self.mouseLeaveTimer);

                self.model.set('subNavIsActive', true);
            },
            mouseleave: function() {
                var self = this;

                if (W.innerWidth < F.menuBreakPoint) {
                    return;
                }

                self.mouseLeaveTimer = setTimeout(function() {
                    self.model.set('subNavIsActive', false);
                }, 400);
            }
        },

        init: function() {
            var self = this;

            self.model.onChange('subNavIsActive', function() {
                self.openCloseLogic();
            });

            SubNavModel.onChange('currentlyActiveGuid', function(val) {
                if (val === self.model.guid) {
                    return;
                }

                self.model.set('subNavIsActive', false);
            });
        },

        openCloseLogic: function() {
            var self = this;

            var mobileMenuIsActive = self.model.get('subNavIsActive');

            if (mobileMenuIsActive) {
                self.openSubMenu();
                return;
            }

            self.closeSubMenu();
        },

        openSubMenu: function() {
            var self = this;

            self.$el.addClass(self.$el.data('subNavActiveClass'));

            SubNavModel.set('currentlyActiveGuid', self.model.guid);

            self.$el.addClass(self.$el.data('subNavOpenClass'));
            self.$el.find('.JSSubNav__List').slideDown(menuAnimationTime);
        },

        closeSubMenu: function() {
            var self = this;

            self.$el.removeClass(self.$el.data('subNavActiveClass'));

            self.$el.removeClass(self.$el.data('subNavOpenClass'));
            self.$el.find('.JSSubNav__List').slideUp(menuAnimationTime);
        }
    });
}

runSubNav(window.FAB, window);
