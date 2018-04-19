// Make sure FAB is defined
window.FAB = window.FAB || {};

function runContactForm(F) {
    'use strict';

    if (! window.jQuery || ! F.controller) {
        setTimeout(function() {
            runContactForm(F);
        }, 10);
        return;
    }

    F.controller.make('ContactForm', {
        events: {
            submit: function(e) {
                e.preventDefault();
                this.submitForm();
            }
        },

        init: function() {
            var self = this;

            self.$el.attr('novalidate', 'novalidate');

            /**
             * Take care of our honeypots
             */
            self.$el.find('.BlockContact__Input--Site')
                .add('.BlockContact__Input--MailingAddress')
                .attr('required', false)
                .attr('tabindex', '-1')
                .attr('autocomplete', 'off')
                .val('');
        },

        submitForm: function() {
            var self = this;
            var $submitButton = self.$el.find('.JSContactForm__SubmitButton');

            $submitButton.attr('disabled', true)
                .text($submitButton.data('working'));

            $.ajax({
                url: window.location.href,
                data: self.$el.serialize(),
                method: 'POST',
                success: function(json) {
                    if (! json.success) {
                        $submitButton.attr('disabled', false)
                            .text($submitButton.data('value'));

                        self.parseErrors(json);

                        return;
                    }

                    window.location = json.redirect;
                }
            });
        },

        parseErrors: function(json) {
            var self = this;
            var $errorMessageWrapper = self.$el.closest('.JSTwoColumnContainer')
                .find('.JSContactForm__ErrorMessage');
            var $errorHtml = $($('#JSTemplate__TwoColumnNoteIsError').html());

            self.$el.find('.JSContactForm__InputWrapper').removeClass(
                'BlockContact__InputLabel--HasError'
            );

            self.$el.find('.JSContactForm__Input').removeClass(
                'BlockContact__Input--HasError'
            );

            self.$el.find('.BlockContact__InputErrorMessage').remove();

            self.$el.find(':input').off('change.validate').off('keyup.validate');

            $errorHtml.find('.JSNote__Title').text('Form Submission Error');
            $errorHtml.find('.JSNote__Body').text(json.message);

            $errorMessageWrapper.html($errorHtml.html());

            for (var inputName in json.inputErrors) {
                if (json.inputErrors.hasOwnProperty(inputName)) {
                    (function(inputName, errorMessage) {
                        var $input = self.$el.find('[name="' + inputName + '"]');
                        var $parent = $input.closest('.JSContactForm__InputWrapper');

                        console.log($input);

                        $parent.addClass('BlockContact__InputLabel--HasError');
                        $input.addClass('BlockContact__Input--HasError');

                        $parent.append(
                            '<div class="BlockContact__InputErrorMessage">' +
                            errorMessage +
                            '</div>'
                        );

                        $input.on('change.validate keyup.validate', function() {
                            $parent.removeClass('BlockContact__InputLabel--HasError');
                            $input.removeClass('BlockContact__Input--HasError');
                            $parent.find('.BlockContact__InputErrorMessage').remove();
                        });
                    })(inputName, json.inputErrors[inputName]);
                }
            }
        }
    });
}

runContactForm(window.FAB);
