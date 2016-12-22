function Movie() {
    this.init = function() {
        //
    }

    this.show = function() {
        $('#delete-item').on('click', function(e) {
            e.preventDefault();
            var itemId = $(e.target).data('id');
            $(e.target).attr('disabled', true);

            // TODO: ask confiramtion before deleting

            $.deleteJSON('/api/movies/' + itemId, [], function(res) {
                if (res.Status == 1) {
                    var successBlock = ''
                        + '<div class="alert alert-success alert-dismissible" role="alert">'
                        + '    <button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                        + '        <span aria-hidden="true">&times;</span>'
                        + '    </button>'
                        + '    <strong>Well done!</strong> You successfully deleted this movie'
                        + '</div>';
                    $('#content .wrapper').prepend(successBlock);
                    setTimeout(function () {
                        window.location.href = '/movies';
                    }, 2000);
                } else {
                    $(e.target).attr('disabled', false);
                    var errorBlock = ''
                        + '<div class="alert alert-danger alert-dismissible" role="alert">'
                        + '    <button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                        + '        <span aria-hidden="true">&times;</span>'
                        + '    </button>'
                        + '    <strong>Oh snap!</strong> Change a few things up and try submitting again.'
                        + '</div>';
                    $('#content .wrapper').prepend(errorBlock);
                }
            });
        });
    }

    this.create = function() {
        $('#genre').chosen({width: '100%'});
        $('#format').chosen({width: '100%'});
        $('#director').chosen({width: '100%'});
        $('#casts').chosen({width: '100%'});

        $('form').on('submit', function(e) {
            e.preventDefault();
            $('button.close').closest('.alert').detach().remove();
            $(e.target).find('input[type=submit]').attr('disabled', true);
            var params = {
                Title: $('#title').val(),
                Year: $('#year').val(),
                Genre: $('#genre').val(),
                Director: $('#director').val(),
                Format: $('#format').val().length ? $('#format').val() : undefined,
                Stars: $('#casts').val(),
            };

            // TODO: implement validation before send data to server

            $.postJSON('/api/movies', params, function(res) {
                if (res.Status == 1) {
                    var successBlock = ''
                        + '<div class="alert alert-success alert-dismissible" role="alert">'
                        + '    <button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                        + '        <span aria-hidden="true">&times;</span>'
                        + '    </button>'
                        + '    <strong>Well done!</strong> You successfully inserted movie'
                        + '</div>';
                    $('#content .wrapper').prepend(successBlock);
                    setTimeout(function () {
                        window.location.href = '/movies/' + res.MovieId;
                    }, 2000);
                } else {
                    $(e.target).find('input[type=submit]').attr('disabled', false);
                    var errorBlock = ''
                        + '<div class="alert alert-danger alert-dismissible" role="alert">'
                        + '    <button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                        + '        <span aria-hidden="true">&times;</span>'
                        + '    </button>'
                        + '    <strong>Oh snap!</strong> Change a few things up and try submitting again.'
                        + '</div>';
                    $('#content .wrapper').prepend(errorBlock);
                }
            });
        });
    }

    this.update = function() {
        $('#genre').chosen({width: '100%'});
        $('#format').chosen({width: '100%'});
        $('#director').chosen({width: '100%'});
        $('#casts').chosen({width: '100%'});

        $('form').on('submit', function(e) {
            e.preventDefault();
            $('button.close').closest('.alert').detach().remove();
            $(e.target).find('input[type=submit]').attr('disabled', true);
            var itemId = $(e.target).data('id');
            var params = {
                Title: $('#title').val(),
                Year: $('#year').val(),
                Genre: $('#genre').val(),
                Director: $('#director').val(),
                Format: $('#format').val().length ? $('#format').val() : undefined,
                Stars: $('#casts').val(),
            };

            // TODO: implement validation before send data to server

            $.postJSON('/api/movies/' + itemId, params, function(res) {
                if (res.Status == 1) {
                    var successBlock = ''
                        + '<div class="alert alert-success alert-dismissible" role="alert">'
                        + '    <button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                        + '        <span aria-hidden="true">&times;</span>'
                        + '    </button>'
                        + '    <strong>Well done!</strong> You successfully updated this movie'
                        + '</div>';
                    $('#content .wrapper').prepend(successBlock);
                    setTimeout(function () {
                        window.location.href = '/movies/' + res.Movie.Id;
                    }, 2000);
                } else {
                    $(e.target).find('input[type=submit]').attr('disabled', false);
                    var errorBlock = ''
                        + '<div class="alert alert-danger alert-dismissible" role="alert">'
                        + '    <button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                        + '        <span aria-hidden="true">&times;</span>'
                        + '    </button>'
                        + '    <strong>Oh snap!</strong> Change a few things up and try submitting again.'
                        + '</div>';
                    $('#content .wrapper').prepend(errorBlock);
                }
            });
        });
    }
}
