<?php

namespace Service\X;

/**
 *  @class \Service\X\WrongAuthorization
 *
 */

class WrongAuthorization extends \Service\X
{

    protected $type = 'AUTHORIZATION_ERROR';

    protected $fields = array(
        'Email'    => 'INCORRECT',
        'Password' => 'INCORRECT',
    );

    protected $message = 'Incorrect login or password';
}
