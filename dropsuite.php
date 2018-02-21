<?php

class BigFile
{
    protected $file;

    public function __construct($filename, $mode = "r")
    {
        if (!file_exists($filename)) {

            throw new Exception("File not found");

        }

        $this->file = new SplFileObject($filename, $mode);
    }

    protected function iterateText()
    {
        $count = 0;

        while (!$this->file->eof()) {

            yield $this->file->fgets();

            $count++;
        }
        return $count;
    }

    protected function iterateBinary($bytes)
    {
        $count = 0;

        while (!$this->file->eof()) {

            yield $this->file->fread($bytes);

            $count++;
        }
    }

    public function iterate($type = "Text", $bytes = NULL)
    {
        if ($type == "Text") {

            return new NoRewindIterator($this->iterateText());

        } else {

            return new NoRewindIterator($this->iterateBinary($bytes));
        }

    }
}

?>

<?php

ini_set("memory_limit", "1G");

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


            $handleFile = new BigFile($file_in_dir);
            $iterator = $handleFile->iterate("Text");
            $lines = "";
            foreach($iterator as $line){

                $lines .= $line . PHP_EOL;
            }

//            echo md5($lines).PHP_EOL;

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
        echo 'Unable to open path : ' . $path;
    }
}

function readTheFile($path)
{
    $handle = fopen($path, "r");

    while (!feof($handle)) {
        yield trim(fgets($handle));
    }

    fclose($handle);
}

if (PHP_SAPI == 'cli') {
    $path = $argv[1] . "/";

    echo "Loading ...." . PHP_EOL;

    $result = init($path);

    echo "Content : " . $result->content_item . PHP_EOL;
    echo "Count : " . $result->count . PHP_EOL;

    echo "Finish";

}

?>

