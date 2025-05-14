<?php
require_once '../Entity/Author.php';
class AuthorRepository
{
    public function findall(): array
    {
        try {
            $dbconn = Db::getDbConnection();
            $stmt = "SELECT * FROM author";
            $request = $dbconn->prepare($stmt);
            $request->execute();

            $array = $request->fetchAll(PDO::FETCH_ASSOC);
//        print_r($array);
            $author = [];
            foreach ($array as $item) {
                $author_array = new Author($item['id'], $item['fname'], $item['lname'], $item['bday'], $item['country']);
                $author[] = $author_array;
            }

        }catch (PDOException $e){
            echo "Error; ", $e->getmessage();
        }
        return $author;
    }


    public function findbyid($id): array
    {
        try {
            $dbconn = Db::getDbConnection();
            $stmt = "SELECT * FROM author WHERE id= :id";
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
            $stmt = "DELETE FROM author WHERE id = :id";
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
            $dbconn = Db::getDbConnection();
            $stmt = "UPDATE author SET ";
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
            echo "Error: ", $e->getMessage();
        }

        return 0;
    }


    public function create($fname, $lname, $bday, $country)
    {
        try {
            $dbconn = Db::getDbConnection();
            $stmt = "INSERT INTO author(fname,lname,bday,country)
                    values (:fname, :lname, :bday, :country)";
            $request = $dbconn->prepare($stmt);
            $request->bindParam(':fname', $fname);
            $request->bindParam(':lname', $lname);
            $request->bindParam(':bday', $bday);
            $request->bindParam(':country', $country);

            $request->execute();
        }catch (PDOException $e){
            echo "Error: ", $e->getMessage();
        }

    }

}



echo "<pre>";
//foreach ($author->findbyid(4) as $a){
//  var_dump($a. "\n");
//}
$repo = new AuthorRepository();

//print_r($repo->findall());
foreach ($repo->findall() as $author){
    echo $author->fname."\n";
}
//print_r($repo->findbyid(1));
$update = [
    'fname' => 'Fyodor',
    'lname'=> 'Dostoevoski',
    'bday'=> '1821-11-11',
    'country'=> 'Russia'];
//$repo->update(3, $update);

//print_r($repo->findbyid(3));

//$create = $repo->create('jeetu', 'pathak', '1988-03-31', 'India');
//print_r($create);

$remove = $repo->remove(5);
//print_r($repo->findall());
echo "</pre>";