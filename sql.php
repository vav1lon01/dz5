<?php


abstract class Model
{
    public $arrayId = [];
    static function find($id)
    {
        $nameTable = strtolower(get_called_class());
        $sqlSelect = "SELECT * FROM ".$nameTable." WHERE id = ".$id;
        return $sqlSelect;
    }
    public function delete()
    {
        $nameTable = strtolower(get_called_class());
        $sqlDelete = 'DELETE FROM  '.$nameTable.' WHERE id = :id';
        return $sqlDelete;
    }
    public function save()
    {
        $arrayName = get_object_vars($this);
        unset($arrayName['arrayId']);
        $nameTable = strtolower(get_called_class());
        if (in_array($arrayName['id'], $this->arrayId)){
            unset($arrayName['id']);
            $name = array_keys($arrayName);
            $a = [];
            foreach ($name as $value){
                $a[] = $value.' = :'.$value;
            }
            $sqlUpdate = 'UPDATE '.$nameTable.' SET '.implode(', ', $a).', WHERE id = :'.$this->id;
            return $sqlUpdate;
        }else{
            $name = array_keys($arrayName);
            $valueName = array_map(function ($value){
                return ':'.$value;
            }, $name);
            $sqlCreate = 'INSERT INTO '.$nameTable.'('.implode(',',$name).') VALUES '.'('.implode(', ', $valueName).')';
            $this->arrayId[] = $arrayName['id'];
            return $sqlCreate;
        }

    }

}
final class User extends Model
{
    public $id;
    public $name;
    public $email;


}
$user = new User();
$user->id = 1;
$user->name = 'vova';
$user->email = '1@mail.com';
var_dump(User::find(1));
var_dump($user->save());
var_dump($user->delete(5));
var_dump($user->save());
