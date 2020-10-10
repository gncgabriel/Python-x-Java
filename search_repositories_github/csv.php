<?php

function createCsv($data, $dir)
{

  $fileContent = implode(',', array_values($data));
  $fileContent .= "\r\n";

  $file = fopen($dir . '/analises.csv', 'a+');
  fwrite($file, $fileContent);
  fclose($file);
}

function apagarCsv($dir)
{
  if (file_exists($dir . "/analises.csv")) {
    unlink($dir . "/analises.csv");
  }
}
