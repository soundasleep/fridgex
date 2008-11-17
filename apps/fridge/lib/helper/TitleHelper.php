<?php

/**
 * Help set the page title in the template itself.
 */
function set_title($a) {
  sfContext::getInstance()->getResponse()->setTitle(!$a ? sfConfig::get("app_title") : sfConfig::get("app_title_prefix", "") . $a . sfConfig::get("app_title_suffix", ""));
}
