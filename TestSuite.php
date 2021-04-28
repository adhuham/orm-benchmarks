<?php

require_once dirname(__FILE__) . '/sfTimer.php';

abstract class TestSuite
{
    protected $con;
    private const NB_TEST = 4000;

    abstract public function initialize();
    abstract public function runInsertTag($i);
    abstract public function runInsertPost($i);
    abstract public function runSelect($i);
    abstract public function runWhere($i);
    abstract public function runHydrate($i);
    abstract public function runJoin($i);

    public function initTables()
    {
        try {
            $this->con->exec('DROP TABLE [post]');
            $this->con->exec('DROP TABLE [tag]');
        } catch (PDOException $e) {
        }

        $this->con->exec('CREATE TABLE [post] (
			[id] INTEGER  NOT NULL PRIMARY KEY,
			[title] VARCHAR(255)  NOT NULL,
			[content] VARCHAR(255)  NOT NULL,
			[author_id] INTEGER NOT NULL,
			[author_name] VARCHAR(255) NOT NULL,
			[tag_id] INTEGER NOT NULL,
			FOREIGN KEY (tag_id) REFERENCES tag(id))
        ');

        $this->con->exec('CREATE TABLE [tag] (
            [id] INTEGER NOT NULL PRIMARY KEY,
            [name] VARCHAR(128) NOT NULL)
        ');
    }

    public function run()
    {
        $t1 = $this->runTest('runInsertTag', 1000);
        $t1 += $this->runTest('runInsertPost', 1000);

        $t2 = $this->runTest('runSelect', 1000);
        $t3 = $this->runTest('runWhere', 1000);
        $t4 = $this->runtest('runHydrate', 1000);
        $t5 = $this->runtest('runJoin', 1000);

        echo sprintf(
            "| %32s | %20d | %20d | %20d | %20d | %20d | ",
            $this->name ?? str_replace('TestSuite', '', get_class($this)),
            $t1[0] ?? null,
            $t2[0] ?? null,
            $t3[0] ?? null,
            $t4[0] ?? null,
            $t5[0] ?? null,
        );
    }

    public function runTest($methodName, $nbTest = self::NB_TEST)
    {
        $timer = new sfTimer();

        for ($i = 0; $i < $nbTest; $i++) {
            $this->$methodName($i);
        }

        $t = $timer->getElapsedTime();

        return [$t * 1000, 0];
    }
}
