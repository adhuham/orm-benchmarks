<?php

require_once dirname(__FILE__) . '/../TestSuite.php';

use Illuminate\Database\Capsule\Manager as Capsule;

class LaravelBuilder extends TestSuite
{
    protected $name = 'Laravel Query Builder';

    protected $capsule = null;

    public function initialize()
    {
        $loader = require_once "vendor/autoload.php";

        $this->capsule = new Capsule();
        $this->capsule->addConnection([
            'driver'    => 'sqlite',
            'database'  =>  ':memory:',
        ]);

        $this->con = $this->capsule->getConnection()->getPdo();
        $this->capsule->setAsGlobal();
        $this->capsule->bootEloquent();

        $this->initTables();
    }

    public function runInsertTag($i)
    {
        $tag = Capsule::table('tag')
            ->insertGetId([
                'name' => 'Tag' . $i,
            ]);
        $this->tag[] = $tag;
    }

    public function runInsertPost($i)
    {
        $post = Capsule::table('post')
            ->insertGetId([
                'title' => 'Hello' . $i,
                'content' => 'Hello World',
                'author_id' => $i,
                'author_name' => 'John' . $i,
                'tag_id' => $i,
            ]);
        $this->post[] = $post;
    }

    public function runSelect($i)
    {
        $result = Capsule::table('post')
             ->select('id', 'title', 'content', 'author_id', 'author_name')
             ->first();
    }

    public function runWhere($i)
    {
        Capsule::table('post')
             ->select('id', 'title', 'content', 'author_id', 'author_name')
             ->where('title', 'Hello' . $i)
             ->orWhere('author_name', 'John' . $i)
             ->where(function ($q) {
                 $q->whereBetween('id', [0, 100000]);
             })
             ->first();
    }

    public function runHydrate($i)
    {
        $posts = Capsule::table('post')
             ->select('id', 'title', 'content', 'author_id', 'author_name')
             ->where('title', 'Hello' . $i)
             ->get();

        foreach ($posts as $post) {
        }
    }

    public function runJoin($i)
    {
        $posts = Capsule::table('post')
             ->select('title', 'content', 'author_id', 'author_name')
             ->leftJoin('tag', 'post.tag_id', '=', 'tag.id')
             ->where('title', 'Hello' . $i)
             ->first();
    }
}
