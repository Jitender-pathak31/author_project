<?php

trait GetterSetter{

    public function __get($name)
    {
        return $this->$name;
    }
    public function __set($name, $value)
    {
        return $this->$name = $value;
    }
}

class Book
{
    use GetterSetter;

    private int $id;
    private string $isbn;
    private DateTime $publication_date;
    private int $pages;
    private string $title;
    private float $price;
    private string $category;

    private bool $hardcover;
    private array $author;

    public function __construct($id, $isbn, $publication_date, $pages, $title, $price, $category, $author)
    {
        $this->id = $id;
        $this->isbn = $isbn;
        $this->publication_date = $publication_date;
        $this->pages = $pages;
        $this->title = $title;
        $this->price = $price;
        $this->category = $category;
        $this->author = $author;
    }

}

$test = new Book(1,'9874640', new DateTime('2025-01-01'), 230,
    'Crime and punishment', 49.99, 'Fiction', ['abc', 'bdc']);

echo $test->category;