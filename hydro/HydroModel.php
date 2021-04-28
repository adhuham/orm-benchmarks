<?php

require_once dirname(__FILE__) . '/../TestSuite.php';

class HydroModel extends TestSuite
{
    protected $name = 'Hydro (using Models)';

    private $postModel;
    private $tagModel;

    public function initialize()
    {
        $loader = require_once dirname(__FILE__) . '/../../Hydro/vendor/autoload.php';

        $this->con = new PDO('sqlite::memory:');
        $this->hydro = new Hydro\Hydro($this->con);

        $loader->add('', __DIR__ . '/models');

        $this->postModel = new Post();
        $this->tagModel = new Tag();

        $this->tagModel->hydro = $this->hydro;
        $this->postModel->hydro = $this->hydro;

        $this->initTables();
    }

    public function runInsertTag($i)
    {
        $tag = $this->tagModel->query()
            ->insert([
                'name' => 'Tag' . $i,
            ])->execute();
        $this->tag[] = $this->hydro->lastInsertId();
    }

    public function runInsertPost($i)
    {
        $post = $this->postModel->query()
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
        $this->postModel->query()->one();
    }

    public function runWhere($i)
    {
        $this->postModel->query()
             ->where('post.title', 'Hello' . $i)
             ->orWhere('post.author_name', 'John' . $i)
             ->where(function ($q) {
                 $q->whereBetween('post.id', [0, 100000]);
             })
             ->one();
    }

    public function runHydrate($i)
    {
        $posts = $this->postModel->query()
             ->where('title', 'Hello' . $i)
             ->get();

        foreach ($posts as $post) {
        }
    }

    public function runJoin($i)
    {
        $posts = $this->postModel->query()
                      ->limit(1)
                      ->one();
    }
}
