<?php namespace Phaza\LaravelPostgis\Schema;

class Blueprint extends \Bosnadev\Database\Schema\Blueprint
{
    /**
     * Add a point column on the table
     *
     * @param      $column
     * @return \Illuminate\Support\Fluent
     */
    public function point($column)
    {
        return $this->addColumn('point', $column);
    }

    /**
     * Add a multipoint column on the table
     *
     * @param      $column
     * @return \Illuminate\Support\Fluent
     */
    public function multipoint($column)
    {
        return $this->addColumn('multipoint', $column);
    }

    /**
     * Add a polygon column on the table
     *
     * @param      $column
     * @return \Illuminate\Support\Fluent
     */
    public function polygon($column)
    {
        return $this->addColumn('polygon', $column);
    }

    /**
     * Add a multipolygon column on the table
     *
     * @param      $column
     * @return \Illuminate\Support\Fluent
     */
    public function multipolygon($column)
    {
        return $this->addColumn('multipolygon', $column);
    }

    /**
     * Add a linestring column on the table
     *
     * @param      $column
     * @return \Illuminate\Support\Fluent
     */
    public function linestring($column)
    {
        return $this->addColumn('linestring', $column);
    }

    /**
     * Add a multilinestring column on the table
     *
     * @param      $column
     * @return \Illuminate\Support\Fluent
     */
    public function multilinestring($column)
    {
        return $this->addColumn('multilinestring', $column);
    }

    /**
     * Add a geography column on the table
     *
     * @param   string  $column
     * @return \Illuminate\Support\Fluent
     */
    public function geography($column)
    {
        return $this->addColumn('geography', $column);
    }

    /**
     * Add a geometrycollection column on the table
     *
     * @param      $column
     * @param null $srid
     * @param int $dimensions
     * @param bool $typmod
     * @return \Illuminate\Support\Fluent
     */
    public function geometrycollection($column, $srid = null, $dimensions = 2, $typmod = true)
    {
        return $this->addCommand('geometrycollection', compact('column', 'srid', 'dimensions', 'typmod'));
    }

    /**
     * Enable postgis on this database.
     * Will create the extension in the database.
     *
     * @return \Illuminate\Support\Fluent
     */
    public function enablePostgis()
    {
        return $this->addCommand('enablePostgis');
    }

    /**
     * Disable postgis on this database.
     * WIll drop the extension in the database.
     * @return \Illuminate\Support\Fluent
     */
    public function disablePostgis()
    {
        return $this->addCommand('disablePostgis');
    }

    /**
     * Specify an index for the table.
     *
     * @param  string|array  $columns
     * @param  string  $name
     * @return \Illuminate\Support\Fluent
     */
    public function gist($columns, $name = null)
    {
        return $this->indexCommand('gist', $columns, $name);
    }

    /**
     * Add the index commands fluently specified on columns.
     *
     * @return void
     */
    protected function addFluentIndexes()
    {
        foreach ($this->columns as $column) {
            foreach (['primary', 'unique', 'index', 'gist'] as $index) {
                // If the index has been specified on the given column, but is simply
                // equal to "true" (boolean), no name has been specified for this
                // index, so we will simply call the index methods without one.
                if ($column->$index === true) {
                    $this->$index($column->name);

                    continue 2;
                }

                // If the index has been specified on the column and it is something
                // other than boolean true, we will assume a name was provided on
                // the index specification, and pass in the name to the method.
                elseif (isset($column->$index)) {
                    $this->$index($column->name, $column->$index);

                    continue 2;
                }
            }
        }
    }
}
