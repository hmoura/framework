<?php

// arquivo que guarda variáveis globais

global $FIELDS;
global $MSG;
global $DATA;

// default definitions
$dao = new DAO();

// default messages
$MSG = new stdClass();
$MSG->success = NULL;// green
$MSG->error   = NULL;// red
$MSG->alert   = NULL;// yellow
$MSG->notice  = NULL;// blues

$DATA = @$_POST['data'] ? @$_POST['data'] : FALSE;

// define mysqli link
global $MYSQLI; 
$MYSQLI = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);

?>