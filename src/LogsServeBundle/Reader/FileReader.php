<?php

namespace LogsServeBundle\Reader;

use LogsServeBundle\Exception\ReaderException;

class FileReader
{
    public function read($path, $line)
    {
        $data = $this->getTail($path, $line);
        $logs = $this->explodeLogs($data);
        $reverseLogs = $this->reverseArray($logs);

        return $reverseLogs;
    }

    public function getTail($path, $line)
    {
        $file = @fopen($path, "rb");
        if ($file === false) {
            throw new ReaderException('File not found!');
        }
        $buffer = ($line < 2 ? 64 : ($line < 10 ? 512 : 4096));
        fseek($file, -1, SEEK_END);
        if (fread($file, 1) != "\n") {
            $line -= 1;
        }

        $output = '';
        $chunk = '';

        while (ftell($file) > 0 && $line >= 0) {
            $seek = min(ftell($file), $buffer);
            fseek($file, -$seek, SEEK_CUR);
            $output = ($chunk = fread($file, $seek)) . $output;
            fseek($file, -mb_strlen($chunk, '8bit'), SEEK_CUR);
            $line -= substr_count($chunk, "\n");
        }

        while ($line++ < 0) {
            $output = substr($output, strpos($output, "\n") + 1);
        }
        fclose($file);

        return trim($output);
    }

    public function explodeLogs($data)
    {
        $lines = explode("\n", $data);

        return $lines;
    }

    public function reverseArray($array)
    {
        return array_reverse($array);
    }
}
