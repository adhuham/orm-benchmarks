<?php

class Post extends Hydro\Model
{
    public $table = 'post';
    public $fields = ['id', 'title', 'content', 'author_id', 'author_name', 'tag_id'];

    public function initialize()
    {
        $this->join['tag'] = function ($q) {
            $q->leftJoin(Tag::class, 'post.tag_id', '=', 'tag.id');
        };
    }
}
