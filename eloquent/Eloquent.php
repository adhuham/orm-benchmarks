<?php

require_once dirname(__FILE__) . '/../TestSuite.php';

class Eloquent extends TestSuite
{
    protected $name = 'Eloquent ORM';

    protected $capsule = null;

    public function initialize()
    {
        $loader = require_once "vendor/autoload.php";

        $this->capsule = new Illuminate\Database\Capsule\Manager();

        $this->capsule->addConnection([
            'driver'    => 'sqlite',
            'database'  =>  ':memory:',
        ]);

        $this->con = $this->capsule->getConnection()->getPdo();

        $this->capsule->setEventDispatcher(new \Illuminate\Events\Dispatcher(new \Illuminate\Container\Container()));
        $this->capsule->setAsGlobal();
        $this->capsule->bootEloquent();

        $loader->add('', __DIR__ . '/models');
        $this->initTables();
    }

    public function runInsertTag($i)
    {
        $tag = new Tag();
        $tag->name = 'Tag' . $i;
        $tag->save();

        $this->tag[] = $tag;
    }

    public function runInsertPost($i)
    {
        $post = new Post();
        $post->title = 'Hello' . $i;
        $post->content = 'Hello World';
        $post->author_id = $i;
        $post->author_name = 'John' . $i;
        $post->tag()->associate($this->tag[$i]);
        $post->save();

        $this->post[] = $post;
    }

    public function runSelect($i)
    {
        $result = Post::first();
    }

    public function runWhere($i)
    {
        Post::where('title', 'Hello' . $i)
             ->orWhere('author_name', 'John' . $i)
             ->where(function ($q) {
                 $q->whereBetween('id', [0, 100000]);
             })
             ->first();
    }

    public function runHydrate($i)
    {
        $posts = Post::where('title', 'Hello' . $i)->get();

        foreach ($posts as $post) {
        }
    }

    public function runJoin($i)
    {
        Post::where('title', 'Hello' . $i)
            ->with('tag')
            ->first();
    }
}
