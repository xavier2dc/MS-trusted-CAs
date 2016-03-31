<?php
if (count($argv)!=2)
  die("Usage: $argv[0] authroot.dump");
if (ini_get("allow_url_fopen") != true) {
  die("Enable allow_url_open in php.ini!".PHP_EOL);
}

// read authroot.dump
$filename = $argv[1];
$data = file_get_contents($filename);
if ($data === false)
  die("Couldn't read file");
$cwd = dirname(realpath($filename));

// extract all SHA-1 fingerprints
if (!preg_match_all('/cons: SEQUENCE\s+[0-9]+:d=8  hl=2 l=  20 prim: OCTET STRING      \[HEX DUMP\]:([A-Z0-9]{40})/', $data, $matches)) {
  die("No pattern found!".PHP_EOL);
}

$total = count($matches[1]);
echo "Found ".$total." hashes".PHP_EOL;

// prepare a context to download all certificates
$baseURL = "http://www.download.windowsupdate.com/msdownload/update/v3/static/trustedr/en/";
$ctx = stream_context_create(array('http'=>
  array(
    'timeout' => 15,
  )
));

$i=0;
// loop over each fingerprints
foreach ($matches[1] as $sha) {
  $i++;
  echo "$i/$total. $sha... ";

  // download the corresponding certificate
  $cert = file_get_contents($baseURL.$sha.".crt", false, $ctx);
  if ($cert !== false) {
    echo "downloaded";
    // save the certificate
    $fd = fopen($cwd.DIRECTORY_SEPARATOR.$sha.".crt", "w+");
    if ($fd == null) {
      echo ", error: could not save".PHP_EOL;
      continue;
    }
    fputs($fd, $cert);
    fclose($fd);
    echo ", saved";
  } else {
    echo "download failed!";
  }
  echo PHP_EOL;
}
?>