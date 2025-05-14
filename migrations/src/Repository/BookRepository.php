<?php
require_once '../Entity/Book.php';
class BookRepository
{
    public function findall(): array
    {
        try {
            $dbconn = Db::getDbConnection();
            $stmt = "SELECT * FROM book";
            $request = $dbconn->prepare($stmt);
            $request->execute();

            $array = $request->fetchAll(PDO::FETCH_ASSOC);

            $book = [];
            foreach ($array as $item) {
                $book_array = new Book($item['id'], $item['isbn'], $item['publication_date'],
                                       $item['pages'], $item['title'], $item['price'],
                                       $item['catagory'], $item['hardcover'], $item['author_id']);
                $book[] = $book_array;
            }

        }catch (PDOException $e){
            echo "Error; ", $e->getmessage();
        }
        return $book;
    }


    public function findbyid($id): array
    {
        try {
            $dbconn = Db::getDbConnection();
            $stmt = "SELECT * FROM book WHERE id= :id";
            $request = $dbconn->prepare($stmt);
            $request->bindParam(':id', $id, PDO::PARAM_INT);
            $request->execute();
            if ($request->rowCount() == null) {
                throw new Exception("Id: $id does not exit!\n");
            }
        }catch (Exception $e){
            echo $e->getMessage();
        }
        return $request->fetchAll();
    }

    public function remove($id)
    {
        try{
            $dbconn = Db::getDbConnection();
            $stmt = "DELETE FROM book WHERE id = :id";
            $request = $dbconn->prepare($stmt);
            $request->bindParam(':id', $id, PDO::PARAM_INT);
            $request->execute();
            if($request->rowCount() == null){
                throw new Exception("Id: $id does not Exist!.\n");
            }

        }catch (Exception $e){
            echo "Error: ", $e->getMessage();
        }
        return true;
    }

    public function update(int $id, array $data): bool
    {
        try {
//            $data = ['isbn', 'publication_date', 'pages', 'title','price', 'catagory', 'hardcover', 'author_id'];
            $dbconn = Db::getDbConnection();
            $stmt = "UPDATE book SET ";
            $sets = [];
            foreach ($data as $key => $value) {
                $sets[] = "$key = :$key";
            }
            $stmt .= implode(',', $sets) . " WHERE id = :id";
            $request = $dbconn->prepare($stmt);
            foreach ($data as $key => $value) {
                $request->bindValue(':' . $key, $value);
            }
            $request->bindValue(':id', $id);
            $request->execute();
        }catch (PDOException $e){
            echo "Error: ",$e->getMessage();
        }

        return 0;
    }


    public function create(array $array)
    {
        $data = ['isbn', 'publication_date', 'pages', 'title','price', 'catagory', 'hardcover', 'author_id'];
        foreach ($data as $key){
            if(!array_key_exists($key, $array)){
                throw new InvalidArgumentException("Missing key: ", $key);
            }
        }
        $dbconn = Db::getDbConnection();
        $stmt = "INSERT INTO book(isbn,publication_date,pages,title,price,catagory,hardcover,author_id)
                    values (:isbn, :publication_date, :pages, :title,:price,:catagory,:hardcover,:author_id)";
        $request = $dbconn->prepare($stmt);
        foreach ($data as $key){
            $request->bindValue(':'.$key, $array[$key]);
        }
        try {
            $request->execute();
        }catch (PDOException $e){
            echo "Error: ", $e->getMessage();
        }

    }

}

$repo = new BookRepository();

//print_r($repo->findbyid(1));
$update = ['isbn' => '978-0140449136',
            'publication_date' => '1866-01-01',
            'pages' => 527,
            'title' => 'Crime and Punishment',
            'price' => 49.99,
            'catagory' => 'Literary Fiction',
            'hardcover' => 1,
            'author_id' => 3];

//print_r($repo->update(1, $update));
$create = ['isbn'=>'978-0140447927','publication_date'=> '1869-01-01',
            'pages' => 659,'title'=> 'The Idiot','price'=> 29.99,
            'catagory'=> 'Novel','hardcover'=> 1,'author_id'=> 3];
//$create = ['978-0140447927','1869-01-01', 659,'The Idiot',29.99, 'Novel', 1, 3];
//print_r($repo->create($create));
//$repo->remove(4);
foreach($repo->findall() as $book){
    echo "The Title of the Books: ".$book->title."\n";
    echo "The number of pages: ".$book->pages."\n";
    echo "\n";
}