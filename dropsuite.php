<?php

ini_set("memory_limit", "4096M");

/**
 * @param $path
 * @return mixed
 */
function init($path)
{

    $files_in_dir = [];

    if (is_dir($path)) {

        if ($dh = opendir($path)) {
            while (($file = readdir($dh)) !== false) {
                $file_read = $path . $file;
                if (is_file($file_read)) {
                    array_push($files_in_dir, $file_read);
                }
            }

        }

        $group = [];
        foreach ($files_in_dir as $index => $file_in_dir) {

            $mime_type = mime_content_type($file_in_dir);
            $lines = "";
            if ($mime_type == 'text/plain') {
                $lines = readTextFile($file_in_dir);
            } else {
                $lines = readBinaryFile($file_in_dir);
            }

            $file_content = md5($lines);
            $content_of_file = $lines;
            $group[$file_content][] = $content_of_file;

        }


        $result = [];
        $content_item = "";
        foreach ($group as $index => $content) {
            $count = count($content);
            foreach ($content as $item) {
                $content_item = $item;
            }
            $obj = new stdClass();
            $obj->content_item = $content_item;
            $obj->count = $count;

            array_push($result, $obj);
        }

        closedir($dh);

        rsort($result);
        return $result[0];


    } else {
        return FALSE;

    }
}

/**
 * @param $file
 * @return bool|string
 */
function readTextFile($file)
{
    $lines = "";
    $handle = fopen($file, "r");
    while (!feof($handle)) {
        $line = fgets($handle, 80);
        $lines .= $line . PHP_EOL;
    }
    fclose($handle);
    return $line;
}

/**
 * @param $file
 * @return bool|string
 */
function readBinaryFile($file)
{
    $handle = fopen($file, "rb");
    $data = fread($handle, 4096);
    $lines = $data;
    fclose($handle);
    return $lines;
}

/**
 * CLI Apps
 */
if (PHP_SAPI == 'cli') {
    $path = $argv[1] . "/";

    echo "Loading ...." . PHP_EOL;

    $result = init($path);

    if (!result) die('Path is unknown');

    echo "Content : " . $result->content_item . PHP_EOL;
    echo "Count : " . $result->count . PHP_EOL;

    echo "Finish";

}

?>

