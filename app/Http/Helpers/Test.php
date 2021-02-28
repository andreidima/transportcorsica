<?php

namespace App\Http\Helpers;


class Test
{    
    private $test1 = 'test1';
    private $test2 = 'test2';

    private $temporaryDirectory = "/tmp";
    
    public $temporaryDirectoryPublic = "/tmp";


    public function __construct($test1, $test2)
    {
        $this->$test1 = "sad";
        $temporaryDirectory = "sad";
        $temporaryDirectoryPublic = "asd";
      
        dd($this->$temporaryDirectory);
    }
}

?>
