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
}
