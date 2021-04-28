<?php

class Post extends Illuminate\Database\Eloquent\Model {

    protected $table = 'post';
    public $timestamps = false;

    public function tag()
    {
        return $this->belongsTo('tag');
    }
}
