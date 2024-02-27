<?php

namespace App\Console\ClassFileGenerator;

use Illuminate\Support\Facades\Schema;

trait RequestGenerator
{
    public function getStubVariablesRequest($className)
    {
        return [
            'modelName'     => $className,
            'columns'       => $this->getReadyColumnsForRequest(),
        ];
    }

    public function getReadyColumnsForRequest()
    {
        $columnsString = "";
        $tableNameData = $this->tableColumnsTypes[$this->tableName];
        $counter = 0;
        foreach ($tableNameData as $columnName => $columnData) {
            if($columnName != 'relations'){
                $validationType = $this->getValidationType($columnData['type'], $columnData['nullable']);
                if ($counter == 0) {
                    $columnsString .= "'" . $columnName . "' => '" . $validationType . "',\n";
                } else {
                    $columnsString .= "            '" . $columnName . "' => '" . $validationType . "',\n";
                }
                $counter++;
            }

        }
        return $columnsString;
    }
    private function getValidationType($columnType, $nullable)
    {
        switch ($columnType) {
            case 'bigIncrements':
            case 'integer':
            case 'unsignedInteger':
            case 'tinyInteger':
            case 'unsignedTinyInteger':
            case 'smallInteger':
            case 'unsignedSmallInteger':
            case 'mediumInteger':
            case 'unsignedBigInteger':
            case 'unsignedMediumInteger':
            case 'foreign':
                return $nullable ? 'nullable|integer' : 'required|integer';
            case 'double':
            case 'float':
            case 'decimal':
                return $nullable ? 'nullable|numeric' : 'required|numeric';
            case 'string':
            case 'char':
            case 'text':
            case 'mediumText':
            case 'longText':
                return $nullable ? 'nullable|string' : 'required|string';
            case 'date':
            case 'dateTime':
            case 'dateTimeTz':
            case 'time':
            case 'timeTz':
            case 'timestamp':
            case 'timestampTz':
                return $nullable ? 'nullable|date' : 'required|date';
            case 'boolean':
                return $nullable ? 'nullable|boolean' : 'required|boolean';
            default:
                return $nullable ? 'nullable|' : 'required|';
        }
    }
}
