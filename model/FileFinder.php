<?php

/**
 * Work with files
 */
class FileFinder
{
    protected string $filePath;
    protected string $fileExt;

    public function __construct(Config $config)
    {
        $this->filePath = ROOT . DIRECTORY_SEPARATOR . $config::FILE_DIRECTORY;
        $this->fileExt = $config::FILE_EXTENSION;
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