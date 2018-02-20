<?php

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
            $file_content = md5(file_get_contents($file_in_dir));
            $content_of_file = file_get_contents($file_in_dir);
            $group[$file_content][] = $content_of_file;

        }

        $result = [];
        $content_item = "";
        foreach ($group as $index => $content) {
            $count = count($content);
            foreach ($content as $item){
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
        echo 'Unable to open path : ' . $path;
    }
}

?>

<?php
if (isset($_POST['path'])) {
    $path = $_POST['path'] . "/";
    $result = init($path);
}
?>