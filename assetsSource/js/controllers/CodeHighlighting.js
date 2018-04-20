// Make sure FAB is defined
window.FAB = window.FAB || {};

function runCodeHighlighting(F) {
    'use strict';

    if (! window.jQuery || ! F.controller) {
        setTimeout(function() {
            runCodeHighlighting(F);
        }, 10);
        return;
    }

    F.controller.make('CodeHighlighting', {
        init: function() {
            F.assets.load({
                css: [
                    'assets/lib/prism/prism.min.css',
                    'assets/lib/prism/lang.customee.min.css'
                ],
                js: [
                    'assets/lib/prism/prism.min.js',
                    'assets/lib/prism/lang.ee.min.js'
                ],
                success: function() {
                    window.Prism.highlightAll();
                }
            });
        }
    });
}

runCodeHighlighting(window.FAB, window);
