<?php

namespace Bang\Tools;

use Bang\Lib\eString;
use Bang\Lib\TextFile;

/**
 * @author Bang
 */
class eFile {

    /**
     * @param type $dir_path
     * @param type $output_file_path
     * @param type $file_sub_name
     */
    public static function CombindTextFilesByDir($dir_path, $output_file_path, $file_sub_name = 'csv') {
        $output = $output_file_path;
        $files = scandir($dir_path);

        $result_file = new TextFile($output);
        $result_file->CreateIfNotFound();

        foreach ($files as $file) {
            if (eString::IsNotNullOrSpace($file_sub_name) && !eString::EndsWith($file, $file_sub_name)) {
                continue;
            }
            $text_file = new TextFile($output_file_path . $file);
            $content = $text_file->Read();
            $result_file->Append($content . "\n");
        }
    }

}
