<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

/**
 * @Desc download exporting file
 */
class DownExportFileController extends Controller
{
    /**
     * @param string $path
     * @return void
     */
    public function index(string $path): void
    {
        set_time_limit(0);
        $path = trim($path, '/ ');
        $filePath = public_path() . '/' . $path;

        if (!$filePath) {
            die("File not found");
        }

        $fileName = File::basename($filePath);
        $mimeType = File::mimeType($filePath);
        $this->outputFile($filePath, $fileName, $mimeType);
    }

    /**
     * @desc output file
     * @param string $path
     * @param string $fileName
     * @param string $mimeType
     * @return void
     */
    public function outputFile(string $path, string $fileName, string $mimeType): void
    {
        ob_end_clean();
        ob_start();
        header('Content-Type: ' . $mimeType);
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Expires: 0');

        $readBuffer = 4096;
        $handle = fopen($path, 'rb');

        while (!feof($handle)) {
            echo fread($handle, $readBuffer);
            ob_flush();
        }

        fclose($handle);
        ob_end_flush();
    }
}
