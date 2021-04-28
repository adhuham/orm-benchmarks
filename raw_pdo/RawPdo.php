<?php

require_once dirname(__FILE__) . '/../TestSuite.php';

class RawPdo extends TestSuite
{
    public function initialize()
    {
        $this->con = new PDO('sqlite::memory:');

        $this->initTables();
    }

    public function runInsertTag($i)
    {
        $q = $this->con->prepare(
            'INSERT INTO tag(name) VALUES (?)'
        );
        $q->bindValue(1, 'Tag' . $i, PDO::PARAM_STR);
        $q->execute();

        $this->tag[] = $this->con->lastInsertId();
    }

    public function runInsertPost($i)
    {
        $q = $this->con->prepare(
            'INSERT INTO post(title, content, author_id, author_name, tag_id)
            VALUES (?, ?, ?, ?, ?)'
        );
        $q->bindValue(1, 'Hello' . $i, PDO::PARAM_STR);
        $q->bindValue(2, 'Hello Wolrd', PDO::PARAM_STR);
        $q->bindValue(3, $i, PDO::PARAM_INT);
        $q->bindValue(4, 'John' . $i, PDO::PARAM_STR);
        $q->bindValue(5, $i, PDO::PARAM_INT);
        $q->execute();

        $this->post[] = $this->con->lastInsertId();
    }

    public function runSelect($i)
    {
        $q = $this->con->prepare('SELECT id, title, content, author_id, author_name FROM post');
        $q->execute();
        $q->fetch();
    }

    public function runWhere($i)
    {
        $q = $this->con->prepare('
            SELECT id, title, content, author_id, author_name 
            FROM post
            WHERE title = ? OR author_name = ? AND (id BETWEEN ? AND ?)
        ');
        $q->bindValue(1, 'Hello' . $i, PDO::PARAM_STR);
        $q->bindValue(2, 'John' . $i, PDO::PARAM_STR);
        $q->bindValue(3, 0, PDO::PARAM_INT);
        $q->bindValue(4, 100000, PDO::PARAM_INT);
        $q->execute();
        $q->fetch();
    }

    public function runHydrate($i)
    {
        $q = $this->con->prepare('
            SELECT id, title, content, author_id, author_name 
            FROM post
            WHERE title = ? 
        ');
        $q->bindValue(1, 'Hello' . $i, PDO::PARAM_STR);
        $q->execute();

        while ($row = $q->fetch()) {
        }
    }

    public function runJoin($i)
    {
        $q = $this->con->prepare('
            SELECT title, content, author_id, author_name 
            FROM post
                LEFT JOIN tag ON (post.tag_id = tag.id)
            WHERE title = ? 
        ');
        $q->bindValue(1, 'Hello' . $i, PDO::PARAM_STR);
        $q->execute();
        $q->fetch();
    }
}
