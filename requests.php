<?php



function getMethod()
{
  return strtolower(request()->method());
}


function isDeleteMethod()
{
  return getMethod() == "delete";
}

function isPatchMethod()
{
  return getMethod() == "patch";
}

function isPostMethod()
{
  return getMethod() == "post";
}

function getRequestData()
{
  return request()->all();
}

function showRequests()
{
  dd(request()->all());
}

function getRequest($key)
{
  return request()->input($key);
}

function getFileRequest($key)
{
  return request()->file($key);
}

function setRequest($key, $value, $request = null)
{
  if ($request != null) {
    $request->set($key, $value);
  } else {
    request()->offsetSet($key, $value);
  }
}

function isRecycleBinMode()
{
  return request()->get("recycle-bin") && request()->get("recycle-bin") == true;
}

function stringToRequest($string)
{
  if ($string == null || trim($string) == "") {
    return array();
  }
  $string = str_replace("?", "", $string);
  parse_str($string, $output);
  return $output;
}


function getFiltersFromUrl()
{
  $string = request()->getRequestUri();
  $result = explode("?", $string);
  if (isset($result[1])) {
    parse_str($result[1], $output);
    return $output;
  }
  return [];
}



function getFilterAttributesFromUrl($array)
{
  $output = [];
  foreach ($array as $key => $value) {
    $i=0;
    foreach ($value as $key2 => $value2) {
      $output[$key][$i] = $key2;
      $i++;
    }
  }
  return $output;
}














