<?php

namespace App\Console\ClassFileGenerator;

trait ModelGenerator
{
    public function getStubVariablesModel($className)
    {
        return [
            'modelName'          => $className,
            // 'relationsFunctions' => $this->relations,
            'relationsFunctions' => $this->getReadyRelations(),
            'tableName'          => $this->tableName,
            'columnsFillables'   => $this->getReadyFillableForModel(),
            'columnsCasts'       => $this->getReadyCastsForModel(),
        ];
    }

    public function getReadyFillableForModel()
    {
        $columnsString = implode("',\n        '", $this->tableColumns);
        return "'" . $columnsString . "'";
    }

    public function getReadyCastsForModel()
    {
        $casts = '';
        $counter = 0;
        foreach ($this->tableColumnsTypes[$this->tableName] as $key => $value) {
            if ($key != 'relations') {
                if ($counter == 0) {
                    if ($value['type'] === 'integer') {
                        $casts .= "'$key' => 'integer',\n";
                    } elseif ($value['type'] === 'float') {
                        $casts .= "'$key' => 'float',\n";
                    } elseif ($value['type'] === 'boolean') {
                        $casts .= "'$key' => 'boolean',\n";
                    } elseif ($value['type'] === 'datetime') {
                        $casts .= "'$key' => 'datetime',\n";
                    } elseif ($value['type'] === 'foreign') {
                        $casts .= "'$key' => 'integer',\n";
                    } else {
                        $casts .= "'$key' => 'string',\n";
                    }
                } else {
                    if ($value['type'] === 'integer') {
                        $casts .= "       '$key' => 'integer',\n";
                    } elseif ($value['type'] === 'float') {
                        $casts .= "       '$key' => 'float',\n";
                    } elseif ($value['type'] === 'boolean') {
                        $casts .= "       '$key' => 'boolean',\n";
                    } elseif ($value['type'] === 'datetime') {
                        $casts .= "       '$key' => 'datetime',\n";
                    } elseif ($value['type'] === 'foreign') {
                        $casts .= "       '$key' => 'integer',\n";
                    } else {
                        $casts .= "       '$key' => 'string',\n";
                    }
                }
                $counter++;
            }
        }
        return $casts;
    }
    private function getReadyRelations()
    {
        $relations = '';

        foreach ($this->tableColumnsTypes[$this->tableName]['relations'] as $relation) {
            // Explode the relation string to get the relationship type and related table
            $relationParts = explode(',', $relation);
            $relationshipType = trim($relationParts[0]);
            $relatedTable = trim($relationParts[1]);
            $modelName = ucfirst($relatedTable);

            if ($relationshipType === 'many-to-one') {
                // Generate the method for one-to-many relationship
                $methodName = strtolower(\Str::plural($relatedTable));
                $relations .= "\n    public function {$methodName}()\n";
                $relations .= "    {\n";
                $relations .= "        return \$this->hasMany({$modelName}::class);\n";
                $relations .= "    }\n";
            } elseif ($relationshipType === 'one-to-many') {
                // Generate the method for many-to-one relationship
                $relations .= "\n    public function {$relatedTable}()\n";
                $relations .= "    {\n";
                $relations .= "        return \$this->belongsTo({$modelName}::class);\n";
                $relations .= "    }\n";
            }
            // Add more conditions as needed for other types of relationships
        }
        return $relations;
    }



}
