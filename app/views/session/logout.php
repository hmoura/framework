<?php

session_destroy();
session_unset();

redirect_to('session/login');
?>