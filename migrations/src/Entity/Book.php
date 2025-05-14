<?php
require_once '../Repository/Db.php';
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
    private int $author_id;

    public function __construct($id, $isbn, $publication_date, $pages, $title, $price, $category, $hardcover, $author_id)
    {
        $this->id = $id;
        $this->isbn = $isbn;
        $this->publication_date = new DateTime($publication_date);
        $this->pages = $pages;
        $this->title = $title;
        $this->price = $price;
        $this->category = $category;
        $this->hardcover = $hardcover;
        $this->author_id = $author_id;

    }


}

//$test = new Book(1,'9874640', new DateTime('2025-01-01'), 230,
//    'Crime and punishment', 49.99, 'Fiction', ['abc', 'bdc']);
//
//echo $test->category;