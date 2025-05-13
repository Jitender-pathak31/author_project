<?php
require_once 'Db.php';

trait GetterSetter{ // using trait to avoid writing many getters and setters
    public function __get($name)
    {
        return $this->$name;
    }
    public function __set($name, $value)
    {
        $this->$name = $value;
    }
}
class Author
{
    use GetterSetter;
    private int $id;
    private string $fname;

    private string $lname;

    private DateTime $bday;

    private string $country;

    private array $book;

    public function __construct($id, $fname, $lname, $bday, $country)
    {
        $this->id = $id;
        $this->fname = $fname;
        $this->lname = $lname;
        $this->bday = new DateTime($bday);
        $this->country = $country;
//        $this->book = $book;
    }
public function addBooks(string $book): void // function to add books in an array
{
   $this->book[] = $book;
}

public function getbooks(): array // to access the books from an array
{
    return $this->book;
}

}

$author = new Author(1, 'fyodor', 'dosto', '1821-11-11', 'Russia', ['Crime and Punishment', 'Idiot']);
//$author = new Author();

//foreach($author->getbooks() as $b){
//        echo $b."\n";
//}

