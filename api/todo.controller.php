<?php
require_once("todo.class.php");

class TodoController {

    private const PATH = __DIR__."/todo.json";
    private $todos = [];    

    public function __construct() {
        $content = file_get_contents(self::PATH);
        if ($content === false) {
            throw new Exception(self::PATH . " does not exist");
        }  
        $dataArray = json_decode($content);
        if (!json_last_error()) {
            foreach($dataArray as $data) {
                if (isset($data->id) && isset($data->title))
                $this->todos[] = new Todo($data->id, $data->title, $data->description, $data->done);
            }
        }
    }
    
    public function loadAll() {
        return $this->todos;      
    }

    public function load(string $id) {
        foreach($this->todos as $todo) {
            if ($todo->id == $id) {
                return $todo;
            }
        }
        return false;
    }

    public function create(Todo $todo) {
        $this->todos[] = $todo;
        return $this->saveTodosToFile();
    }

    private function saveTodosToFile() {
        $json = json_encode($this->todos, JSON_PRETTY_PRINT);
        return file_put_contents(self::PATH, $json) !== false;
    }

    public function update(string $id, Todo $todo) {
        if (!$id || !$todo->id || $id !== $todo->id) {
            return false; 
        }

        foreach ($this->todos as &$existingTodo) {
            if ($existingTodo->id === $id) {
                $existingTodo = $todo;
                return $this->saveTodosToFile();
            }
        }
        return false; 
    }


    public function delete(string $id) {
        foreach ($this->todos as $key => $existingTodo) {
            if ($existingTodo->id === $id) {
                unset($this->todos[$key]);
                return $this->saveTodosToFile();
            }
        }
        return false;
}

    public function get() {
        $content = file_get_contents(self::PATH);
        if ($content === false) {
            throw new Exception(self::PATH . " does not exist");
        }
        $dataArray = json_decode($content, true);
        return $dataArray;
    }

}
