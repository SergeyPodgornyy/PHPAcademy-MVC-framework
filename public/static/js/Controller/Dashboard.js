function Dashboard() {
    this.init = function() {
        //
    }

    this.login = function() {
        var self = this;

        $('form').on('submit', function (e) {
            e.preventDefault();
            $('button.close').closest('.alert').detach().remove();

            var params = {
                Email: $('#email').val(),
                Password: $('#password').val()
            };

            self._sendLoginData(params);
        });
    }

    this.register = function() {
        var self = this;

        $('form').on('submit', function (e) {
            e.preventDefault();
            $('button.close').closest('.alert').detach().remove();

            var params = {
                Name: $('#name').val(),
                Email: $('#email').val(),
                Password: $('#password').val(),
                PasswordRepeat: $('#password_repeat').val()
            };

            $.postJSON('/api/users', params, function(res) {
                if (res.Status == 1) {
                    self._sendLoginData({
                        Email: params.Email,
                        Password: params.Password
                    });
                } else {
                    var errorBlock = ''
                        + '<div class="alert alert-danger alert-dismissible" role="alert">'
                        + '    <button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                        + '        <span aria-hidden="true">&times;</span>'
                        + '    </button>'
                        + '    <strong>' + gettext('Oh snap!') + '</strong> '
                        + (res.Error.Message.length
                            ? res.Error.Message
                            : gettext('Something went wrong. Check your email and password and try submitting again.')
                        )
                        + '</div>';
                    $('#content .wrapper').prepend(errorBlock);
                }
            });
        });
    }

    this._sendLoginData = function(params) {
        $.postJSON('/api/session', params, function(res) {
            if (res.Status == 1) {
                window.location.reload();
            } else {
                var errorBlock = ''
                    + '<div class="alert alert-danger alert-dismissible" role="alert">'
                    + '    <button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                    + '        <span aria-hidden="true">&times;</span>'
                    + '    </button>'
                    + '    <strong>' + gettext('Oh snap!') + '</strong> '
                    + (res.Error.Message.length
                        ? res.Error.Message
                        : gettext('Something went wrong. Check your email and password and try submitting again.')
                    )
                    + '</div>';
                $('#content .wrapper').prepend(errorBlock);
            }
        });
    }
}
