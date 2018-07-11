// Make sure FAB is defined
window.FAB = window.FAB || {};

function runCartSubmission(F) {
    'use strict';

    if (! window.jQuery || ! F.controller) {
        setTimeout(function() {
            runCartSubmission(F);
        }, 10);
        return;
    }

    F.controller.make('CartSubmission', {
        events: {
            'submit': function(e) {
                e.preventDefault();
                this.handleSubmission();
            }
        },

        handleSubmission: function() {
            var self = this;
            var $actionInput = self.$el.find('.JSCheckoutForm__ActionInput');

            self.disableSubmitButton();
            self.hideErrorMessage();

            $actionInput.val($actionInput.data('checkoutAction'));

            $.ajax({
                data: self.$el.serialize(),
                method: 'POST',
                success: function(resp) {
                    var redirect;

                    if (! resp.success) {
                        if (! resp.message) {
                            resp.message = 'We had a problem with your submission';
                        }

                        self.showErrorMessage(resp.message);

                        self.handleSubmissionErrors(resp.checkoutInputErrors);

                        return;
                    }

                    redirect = resp.redirect || '/cart/order-success';

                    location.href = redirect;
                },
                error: function() {
                    alert('An unknown error occurred while submitting your information. This page will refresh so you can try again.');
                    location.reload();
                }
            });
        },

        disableSubmitButton: function() {
            this.$el.find('.JSCheckoutForm__SubmitPayment')
                .prop('disabled', true);
        },

        enableSubmitButton: function() {
            this.$el.find('.JSCheckoutForm__SubmitPayment')
                .prop('disabled', false);
        },

        showErrorMessage: function(msg) {
            var $submissionNotice = $('.JSAjaxCartSubmissionNotice');

            $submissionNotice.show();
            $submissionNotice.find('.JSNote__Body').text(msg);
        },

        hideErrorMessage: function() {
            $('.JSAjaxCartSubmissionNotice').hide();
        },

        handleSubmissionErrors: function(inputErrors) {
            var self = this;

            for (var name in inputErrors) {
                self.handleInputError(name, inputErrors[name]);
            }

            self.enableSubmitButton();
        },

        handleInputError: function(name, errors) {
            var self = this;
            var $input = $('[name="' + name + '"]');
            var $parent = $input.closest('.input-parent');
            var errorHtml = '<ul class="CheckoutForm__InputErrors">';

            errors.forEach(function(error) {
                errorHtml += '<li class="CheckoutForm__InputErrorItem">';
                errorHtml += error;
                errorHtml += '</li>';
            });

            errorHtml += '</ul>';

            if (name === 'expiration') {
                self.handleExpirationErrors(errorHtml);
                return;
            }

            $parent.find('.CheckoutForm__InputErrors').remove();

            if ($input.hasClass('select')) {
                $input.addClass('select--has-error');
            } else {
                $input.addClass('input--has-error');
            }

            $input.after(errorHtml);
        },

        handleExpirationErrors: function(errorHtml) {
            var $expirationParent = $('.expiration-parent');

            $expirationParent.find('.CheckoutForm__InputErrors').remove();

            $expirationParent.find('select').addClass('select--has-error');

            $expirationParent.append(errorHtml);
        }
    });
}

runCartSubmission(window.FAB);
