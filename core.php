<?php

if(!class_exists("DBHelper"))
  {
    require_once(dirname(__FILE__)."/db/DBHelper.php"); 
  }
if(!class_exists("Xml"))
  {
    require_once(dirname(__FILE__)."/xml/xml.php");
  }


if(!function_exists('microtime_float'))
  {
    function microtime_float()
    {
      if(version_compare(phpversion(), '5.0.0', '<'))
        {
          list($usec, $sec) = explode(" ", microtime());
          return ((float)$usec + (float)$sec);
        }
      else
        {
          return microtime(true);
        }
    }
  }

if(!function_exists('dirListPHP'))
  {
    function dirListPHP ($directory,$filter=null,$extension=false,$debug=false) 
    {
      $results = array();
      $handler = @opendir($directory);
      if($handler===false) return false;
      while ($file = readdir($handler)) 
        {
          if ($file != '.' && $file != '..' )  
            {
              if($filter!=null)
                {
                  if($extension!==false)
                    {
                      $parts=explode(".",basename($file));
                      $size=sizeof($parts);
                      $ext_file=array_pop($parts);
                      $filename=implode(".",$parts);
                      if($debug) echo "Looking at extension '$extension' and '$ext_file' for $file and $filename\n";
                      if($ext_file==$extension) 
                        {
                          if(empty($filter)) $results[]=$file;
                          else if(strpos(strtolower($filename),strtolower($filter))!==false) $results[]=$file;
                        }
                    }
                  else if(strpos(strtolower($file),strtolower($filter))!==false) 
                    {
                      $results[]=$file;
                      if($debug) echo "No extension used\n";
                    }
                }
              else 
                {
                  $results[] = $file;
                  if($debug) echo "No filter used \n";
                }
            }
        }
      closedir($handler);
      return $results;
    }
  }

if(!function_exists('array_find'))
  {
    function array_find($needle, $haystack, $search_keys = false, $strict = false) 
    {
      if(!is_array($haystack)) return false;
      foreach($haystack as $key=>$value) 
        {
          $what = ($search_keys) ? $key : $value;
          if($strict)
            {
              if($value==$needle) return $key;
            }
          else if(@strpos($what, $needle)!==false) return $key;
        }
      return false;
    }
  }
if(!function_exists('encode64'))
  {
    function encode64($data) { return base64_encode($data); }
    function decode64($data) 
    {
      if(@base64_encode(@base64_decode($data,true))==$data) return urldecode(@base64_decode($data));
      return false;
    }
  }

if(!function_exists('smart_decode64'))
  {
    function smart_decode64($data,$clean_this=true)
    {
      /*
       * Take in a base 64 object, decode it. Pass back an array 
       * if it's a JSON, and sanitize the elements in any case.
       */
      if(is_null($data)) return null; // in case emptyness of data is meaningful
      $r=decode64($data);
      if($r===false) return false;
      $jd=json_decode($r,true);
      $working= is_null($jd) ? $r:$jd;
      if($clean_this)
        {
          try
            {
              // clean
              require_once(dirname(__FILE__).'/db_hook.inc');
              if(is_array($working))
                {
                  foreach($working as $k=>$v)
                    {
                      $ck=sanitize($k);
                      $cv=sanitize($v);
                      $prepped_data[$ck]=$cv;
                    }
                }
              else $prepped_data=sanitize($working);
            }
          catch (Exception $e)
            {
              // Something broke, probably an invalid data format.
              return false;
            }
        }
      else $prepped_data=$working;
      return $prepped_data;
    }
  }

if(!function_exists('strbool'))
  {
    function strbool($bool)
    {
      // returns the string of a boolean as 'true' or 'false'.
      if(is_string($bool)) $bool=boolstr($bool); // if a string is passed, convert it to a bool
      if(is_bool($bool)) return $bool ? 'true' : 'false';
      else return 'non_bool';
    }
    function boolstr($string)
    {
      // returns the boolean of a string 'true' or 'false'
      if(is_bool($string)) return $string;
      if(is_string($string)) return strtolower($string)==='true' ? true:false;
      if(preg_match("/[0-1]/",$string)) return $string=='1' ? true:false;
      return false;
    }
  }

if(!function_exists('shuffle_assoc'))
  {
    function shuffle_assoc(&$array)
    {
      $keys = array_keys($array);

      shuffle($keys);

      foreach($keys as $key) {
        $new[$key] = $array[$key];
      }

      $array = $new;

      return true;
    }
  }

?>