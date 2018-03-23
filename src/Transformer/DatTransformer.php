<?php

namespace App\Transformer;

use League\Csv\Reader;
use League\Csv\Statement;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Created by PhpStorm.
 * User: adrianalonsovega
 * Date: 23/3/18
 * Time: 20:55
 */
class DatTransformer
{
    /**
     * @var Kernel
     */
    private $kernel;

    /**
     * DatTransformer constructor.
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }


    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     */
    public function transform(\Symfony\Component\HttpFoundation\File\UploadedFile $file)
    {
        $filename = $file->getClientOriginalName();

        $fileTypeIdentifier = substr($filename, 0, 2);
        $model = $this->getModel($fileTypeIdentifier);


        $data = [];
        array_push($data, $model->getHeader());
        if ($file = fopen($file->getPathname(), "r")) {
            while (!feof($file)) {
                $line = fgets($file);
                $data[] = $this->parseRow($line, $model);
            }
            fclose($file);
        }


        return $data;
    }

    /**
     * @param string $fileTypeIdentifier
     * @return Model
     */
    private function getModel(string $fileTypeIdentifier)
    {
        $fileName = $this->kernel->getProjectDir() . "/model-templates/{$fileTypeIdentifier}xxaamm.csv";

        return new Model($fileTypeIdentifier, $fileName);
    }

    /**
     * @param $row
     * @param Model $model
     * @return array
     */
    private function parseRow($line, Model $model)
    {
        $data = [];
        foreach ($model->getRows() as $row) {
            $data[] = substr($line, $row->getOffset(), $row->getLimit());
        }

        return $data;
    }
}
