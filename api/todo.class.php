<?php

class Todo {
    public $id;
    public $title;
    public $description;
    public $done;

    public function __construct(
        string $id, 
        string $title, 
        string $description = '', 
        bool $done = false
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->done = $done;
    }
}
