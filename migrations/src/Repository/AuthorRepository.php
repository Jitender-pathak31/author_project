<?php
include_once "src/Entity/Author.php";
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


}



echo "<pre>";
//foreach ($author->findbyid(4) as $a){
//  var_dump($a. "\n");
//}
$repo = new AuthorRepository();

print_r($repo->findall());
print_r($repo->findbyid(1));
echo "</pre>";