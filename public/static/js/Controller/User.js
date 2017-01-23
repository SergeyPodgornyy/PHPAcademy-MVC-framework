function User() {
    this.init = function() {
        //
    }

    this.update = function() {
        $('form').on('submit', function (e) {
            e.preventDefault();
            $('button.close').closest('.alert').detach().remove();
            $(e.target).find('input[type=submit]').attr('disabled', true);

            var params = {
                Name: $('#name').val(),
                Email: $('#email').val(),
                Password: $('#password').val(),
                PasswordRepeat: $('#password_repeat').val()
            };
            var userId = $('#user').val();

            $.postJSON('/api/users/' + userId, params, function(res) {
                if (res.Status == 1) {
                    var successBlock = ''
                        + '<div class="alert alert-success alert-dismissible" role="alert">'
                        + '    <button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                        + '        <span aria-hidden="true">&times;</span>'
                        + '    </button>'
                        + '    <strong>' + gettext('Well done!') + '</strong> '
                        +      gettext('You successfully updated your personal data')
                        + '</div>';
                    $('#content .wrapper').prepend(successBlock);
                    setTimeout(function () {
                        window.location.reload();
                    }, 2000);
                } else {
                    $(e.target).find('input[type=submit]').attr('disabled', false);
                    var errorBlock = ''
                        + '<div class="alert alert-danger alert-dismissible" role="alert">'
                        + '    <button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                        + '        <span aria-hidden="true">&times;</span>'
                        + '    </button>'
                        + '    <strong>' + gettext('Oh snap!') + '</strong> '
                        + (res.Error.Message.length
                            ? res.Error.Message
                            : gettext('Something went wrong. Check your email and password and try submitting again')
                        )
                        + '</div>';
                    $('#content .wrapper').prepend(errorBlock);
                }
            });
        });
    }
}
