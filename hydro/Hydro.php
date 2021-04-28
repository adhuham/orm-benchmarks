<?php

require_once dirname(__FILE__) . '/../TestSuite.php';

class Hydro extends TestSuite
{
    protected $name = 'Hydro (Normal)';

    public function initialize()
    {
        require_once dirname(__FILE__) . '/vendor/autoload.php';

        $this->con = new PDO('sqlite::memory:');
        $this->hydro = new Hydro\Hydro($this->con);

        $this->initTables();
    }

    public function runInsertTag($i)
    {
        $tag = $this->hydro->table('tag')
            ->insert([
                'name' => 'Tag' . $i,
            ])->execute();
        $this->tag[] = $this->hydro->lastInsertId();
    }

    public function runInsertPost($i)
    {
        $post = $this->hydro->table('post')
            ->insert([
                'title' => 'Hello' . $i,
                'content' => 'Hello World',
                'author_id' => $i,
                'author_name' => 'John' . $i,
                'tag_id' => $i,
            ])->execute();
        $this->post[] = $this->hydro->lastInsertId();
    }

    public function runSelect($i)
    {
        $this->hydro->table('post')
             ->select('id', 'title', 'content', 'author_id', 'author_name')
             ->one();
    }

    public function runWhere($i)
    {
        $this->hydro->table('post')
             ->select('id', 'title', 'content', 'author_id', 'author_name')
             ->where('title', 'Hello' . $i)
             ->orWhere('author_name', 'John' . $i)
             ->where(function ($q) {
                 $q->whereBetween('id', [0, 100000]);
             })
             ->one();
    }

    public function runHydrate($i)
    {
        $posts = $this->hydro->table('post')
             ->select('id', 'title', 'content', 'author_id', 'author_name')
             ->where('title', 'Hello' . $i)
             ->get();

        foreach ($posts as $post) {
        }
    }

    public function runJoin($i)
    {
        $posts = $this->hydro->table('post')
             ->select('title', 'content', 'author_id', 'author_name')
             ->leftJoin('tag', 'post.tag_id', '=', 'tag.id')
             ->where('title', 'Hello' . $i)
             ->limit(1)
             ->one();
    }
}
