<?php

/**
 * Work with files
 */
class File
{
    protected string $filePath;
    protected string $fileExt;

    /**
     * @param string $directory
     * @param string$extension
     */
    public function __construct(string $directory, string $extension)
    {
        $this->filePath = ROOT . DIRECTORY_SEPARATOR . $directory;
        $this->fileExt = $extension;
    }

    /**
     * Return filelist from the puth directory and subdirectories
     *
     * @param string|null $path
     * @return array
     */
    public function getAll(string $path = null): array
    {
        $path = ($path ?? $this->filePath) . DIRECTORY_SEPARATOR;
        $files = [];
        $dir = opendir($path);
        while (false !== ($file = readdir($dir))) {
            if (empty($file) || $file == '.' || $file == '..') continue;
            if (is_dir($path . $file))
                $files += $this->getAll($path . $file);
            if (!is_file($path . $file) || !$this->isValidFile($file)) continue;
            $files[] = $path . $file;
        }
        closedir($dir);
        return $files;
    }

    /**
     * Test valid file extenstion
     *
     * @param string $fileName
     * @return bool
     */
    public function isValidFile(string $fileName): bool
    {
        return ($this->fileExt == pathinfo($fileName, PATHINFO_EXTENSION)) ?? false;
    }

}
?>