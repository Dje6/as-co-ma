<?php
namespace Model;


class RolesModel extends CustomModel
{
  public function deleteRoles($id,$colone)
	{
		if (!is_numeric($id)){
			return false;
		}

		$sql = 'DELETE FROM ' . $this->table . ' WHERE ' . $colone .' = :id LIMIT 1';
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(':id', $id);
		return $sth->execute();
	}

  public function FindRole($id_assoc,$id_user)
  {
    $sql = "SELECT role,id FROM $this->table WHERE id_assoc = :id_assoc AND id_user = :id_user";
    $sth = $this->dbh->prepare($sql);
    $sth->bindvalue(':id_assoc',$id_assoc);
    $sth->bindvalue(':id_user',$id_user);
    $sth->execute();
    $result = $sth->fetch();
    return $result;
  }

  public function AllMembre($id_assoc)
  {
    $sql = "SELECT id_user FROM $this->table WHERE id_assoc = :id_assoc ";
    $sth = $this->dbh->prepare($sql);
    $sth->bindvalue(':id_assoc',$id_assoc);
    $sth->execute();
    $result = $sth->fetchAll();
    return $result;
  }
}
