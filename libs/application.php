<?php

require  __DIR__  . '/aws_signed_request.php';
require __DIR__ . '/Db.class.php';

function xml2array($xml) {
  $arr = array();
  foreach ($xml as $element) {
    $tag = $element->getName();
    $e = get_object_vars($element);
    if (!empty($e)) {
      $arr[$tag] = $element instanceof SimpleXMLElement ? xml2array($element) : $e;
    }
    else {
      $arr[$tag] = trim($element);
    }
  }
  return $arr;
}
