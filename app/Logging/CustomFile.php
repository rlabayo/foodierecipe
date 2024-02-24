<?php
namespace App\Logging;
use Illuminate\Support\Facades\Log;

class CustomFile {

    public static function index($filename, $level, $data = array()){

        config(['logging.channels.custom.path' => storage_path('logs/'.$filename.'_'.date('Y-m-d').'.log')]);
        Log::channel('custom')->$level($data['message']);

    }

}

// Call in controller
// CustomFile::index('ProductController', 'info', [
//     'message' => 'Product'
// ]);



?>