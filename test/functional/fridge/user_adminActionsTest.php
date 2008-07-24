<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$browser = new sfTestBrowser();
$browser->initialize();

$browser->
  get('/user_admin/index')->
  isStatusCode(200)->
  isRequestParameter('module', 'user_admin')->
  isRequestParameter('action', 'index')->
  checkResponseElement('body', '!/This is a temporary page/')
;
