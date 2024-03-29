<?php

namespace App\Console\Commands;

use App\Traits\FileHelper;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Pluralizer;
use Illuminate\Filesystem\Filesystem;
use App\Traits\StringHelper;
use App\Console\Commands\RelationsGenerator;
use App\Console\ClassFileGenerator\Stubs\StubsGenerator;
use App\Console\ClassFileGenerator\Stubs\FilesGenerator;
use App\Console\ClassFileGenerator\RouteGenerator;

class MakeModuleCommand extends Command
{
    use StringHelper, StubsGenerator, FilesGenerator, RouteGenerator;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new full module with full crud operations for an existing migration';

    /**
     * Filesystem instance
     * @var Filesystem
     */
    protected $files;
    protected $tableName;
    protected $tableColumns = [];
    protected $tableColumnsTypes = [];
    protected $relations = "";
    /**
     * Create a new command instance.
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }


    ########################## General Helper Functions ##########################

    //2 step Done
    public function getClassNameFromTableName() //modelName
    {
        return Str::studly(Str::singular($this->tableName));
    }

    public function getPluralVarName()
    {
        return strtolower(Str::plural($this->tableName));
    }

    public function getSingularVarName()
    {
        return strtolower(Pluralizer::singular($this->tableName));
    }


    // 1 step Done
    public function getTablesWithColumns()
    {

        $migrationFiles = scandir(database_path('migrations'));
        $tables = [];

        foreach ($migrationFiles as $file) {
            if (strpos($file, '.php') !== false) {
                $path = database_path('migrations/' . $file);
                $content = file_get_contents($path);
                preg_match('/Schema::create\(\'(.+?)\',.+?\{(.+?)\}\);/s', $content, $matches);
                if (isset($matches[1]) && isset($matches[2])) {
                    $tableName = $matches[1];
                    $columns = $matches[2];
                    preg_match_all('/\$table->(.+?)\(\'(.+?)\'.*?\);/', $columns, $matches2);
                    if (isset($matches2[1]) && isset($matches2[2])) {
                        $columnNames = $matches2[2];
                        $columnsArray = [];
                        foreach ($columnNames as $index => $name) {

                            $columnsArray[] = $name;
                        }
                        $tables[$tableName] = $columnsArray;
                    }
                }
            }
        }
        return $tables;
    }

    public function getTablesWithColumnsTypes()
    {
        $migrationFiles = scandir(database_path('migrations'));
        $tables = [];

        foreach ($migrationFiles as $file) {
            if (strpos($file, '.php') !== false) {
                $path = database_path('migrations/' . $file);
                $content = file_get_contents($path);
                preg_match('/Schema::create\(\'(.+?)\',.+?\{(.+?)\}\);/s', $content, $matches);
                if (isset($matches[1]) && isset($matches[2])) {
                    $tableName = $matches[1];
                    $columns = $matches[2];

                    preg_match_all('/\/\/(.+?)\n/', $columns, $commentMatches);
                    $comments = [];
                    if (!empty($commentMatches[1])) {
                        $comments = $commentMatches[1];
                    }

                    preg_match_all('/\$table->(.+?)\(\'(.+?)\'[^\)]*\)(?:->nullable\(\))?/', $columns, $matches2);
                    if (isset($matches2[1]) && isset($matches2[2])) {
                        $columnNames = $matches2[2];
                        $columnTypes = $matches2[1];
                        $columnsArray = [];

                        // Store all comments as relations
                        $columnsArray['relations'] = $comments;

                        foreach ($columnNames as $index => $name) {
                            $dataType = $this->getColumnDataType($name, $columns);
                            $isNullable = $this->isColumnNullable($columnTypes[$index]);
                            $columnsArray[$name] = ['type' => $dataType, 'nullable' => $isNullable];
                        }

                        // Check for foreign keys
                        preg_match_all('/\$table->foreign\(\'(.+?)\'\)->references\(\'(.+?)\'\)->on\(\'(.+?)\'\)/', $columns, $foreignKeys);
                        if (!empty($foreignKeys[1])) {
                            foreach ($foreignKeys[1] as $fkIndex => $foreignKey) {
                                $columnsArray[$foreignKey] = ['type' => 'foreign', 'nullable' => false];
                            }
                        }

                        $tables[$tableName] = $columnsArray;
                    }
                }
            }
        }
        return $tables;
    }



    private function getColumnDataType($columnName, $columnDefinitions)
    {
        preg_match('/\$table->(?P<type>\w+)\(\'' . $columnName . '\'.*?\);/', $columnDefinitions, $matches);
        if (isset($matches['type'])) {
            $dataType = $matches['type'];
            switch ($dataType) {
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
                    return 'integer';
                case 'double':
                case 'float':
                case 'decimal':
                    return 'float';
                case 'string':
                case 'char':
                case 'text':
                case 'mediumText':
                case 'longText':
                    return 'string';
                case 'date':
                case 'dateTime':
                case 'dateTimeTz':
                case 'time':
                case 'timeTz':
                case 'timestamp':
                case 'timestampTz':
                    return 'datetime';
                case 'boolean':
                    return 'boolean';
            }
        }
        return null;
    }
    private function isColumnNullable($type)
    {
        return strpos($type, 'nullable') !== false; // Check if the type definition contains 'nullable'
    }
    ########################## Main Functionality ##########################

    public function make($stubType)
    {

        $controllerName = $this->getClassNameFromTableName($this->tableName);
        $controllerPath = $this->getSourceFilePath($controllerName, $stubType);
        $this->makeDirectory(dirname($controllerPath));
        $content = $this->getStubContents(
            $this->getStubPath($stubType),
            $this->getStubVariables($stubType, $this->tableColumns)
        );

        $this->fillFile($controllerPath, $content);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $tablesWithColumns = $this->getTablesWithColumns();
        $tablesWithColumnsTypes = $this->getTablesWithColumnsTypes();
        if (count($tablesWithColumns) != 0) {
            $i = 1;
            $tablesName = [];
            foreach ($tablesWithColumns as $key => $value) {
                $tablesName[$i] = $key;
                printf($i . "- " . $key . "\n");
                $i++;
            }
            $selected = $this->ask("Select the table for which you want to create a module .");
            if (is_numeric($selected) && intval($selected) <= count($tablesName)) {
                $selected = ($selected < 0) ? $selected * -1 : $selected;
                $this->tableName = $tablesName[$selected];
                $this->tableColumns = $tablesWithColumns[$this->tableName];


                $this->tableColumnsTypes =  $this->getTablesWithColumnsTypes();
                // foreach ($this->tableColumnsTypes[$this->tableName] as $key => $value) {
                //     printf($value);
                //     return;
                // }
                // print_r($this->tableColumnsTypes[$this->tableName]);
                // return;


                // $this->make('factory');
                $this->make('request');
                $this->make('resource');
                $this->make('controller');
                $this->make('service');
                // $this->make('repository');
                $this->makeRoutes();

                $b = true;
                $relationGenerator = new RelationsGenerator($this, $this->tableName);
                $relationGenerator->setTableName($this->tableName);

                $this->make('model');
            } else {
                printf('Incorrect selection');
                return;
            }
        } else {
            printf('You don\'t have any migration yet...');
        }
    }
}
