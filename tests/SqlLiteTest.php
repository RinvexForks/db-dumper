<?php

namespace Spatie\DbDumper\Test;

use PHPUnit_Framework_TestCase;
use Spatie\DbDumper\Databases\Sqlite;

class SqlLiteTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_provides_a_factory_method()
    {
        $this->assertInstanceOf(Sqlite::class, Sqlite::create());
    }

    /** @test */
    public function it_can_generate_a_dump_command()
    {
        $dumpCommand = Sqlite::create()
            ->setDbName('dbname.sqlite')
            ->getDumpCommand('dump.sql');

        $expected = 'echo $\'BEGIN IMMEDIATE;\n.dump\' | "sqlite3" --bail "dbname.sqlite" > "dump.sql"';

        $this->assertEquals($expected, $dumpCommand);
    }

    /** @test */
    public function it_can_generate_a_dump_command_with_absolute_paths()
    {
        $dumpCommand = Sqlite::create()
            ->setDbName('/path/to/dbname.sqlite')
            ->setDumpBinaryPath('/usr/bin')
            ->getDumpCommand('/save/to/dump.sql');

        $expected = 'echo $\'BEGIN IMMEDIATE;\n.dump\' | "/usr/bin/sqlite3" --bail "/path/to/dbname.sqlite" > "/save/to/dump.sql"';

        $this->assertEquals($expected, $dumpCommand);
    }
}
