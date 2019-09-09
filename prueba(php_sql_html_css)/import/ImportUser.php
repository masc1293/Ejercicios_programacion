<?php
namespace Import;

require 'User.php';

use Import\User;
use PDO;
use PDOException;

class ImportUser {
	public function importUsers($csv) {
		$users = [];

		$row = 1;
		
		$file = fopen($csv, "r");
		
		if (!$file) {
			exit("The file " . $csv . " does not exist \n");
		}
		
		while (($data = fgetcsv($file, 1000, "|")) !== FALSE) {
			if($row == 1) { 
				$row++; 
				continue; 
			} 
			
			$user = new User();
			$user->name = $data[0];
			$user->lastName = $data[1];
			$user->address = $data[2];
			
			$phones = explode('-', $data[3]);
            $user->telephone = $phones[0];
            $user->cellphone = isset($phones[1]) ? ($phones[1] ."\n") : '';
			
			$user->avatar = 'images/' . $data[4];
			
			$users[] = $user;
		}
		
		fclose($file);
		
		return $users;
	}    

	public function saveUsers($db, $user) {
		$sql = "INSERT INTO users (name, last_name, address, telephone, cellphone, avatar) VALUES (:name, :lastName, :address, :telephone, :cellphone, :avatar)"; 

		$process = $db->prepare($sql);

		$process->bindValue(':name', $user->name);
	    $process->bindValue(':lastName', $user->lastName);
	    $process->bindValue(':address', $user->address);
	    $process->bindValue(':telephone', $user->telephone);
	    $process->bindValue(':cellphone', $user->cellphone);
	    $process->bindValue(':avatar', $user->avatar);

	    try {
	    	$process->execute();
        } catch (PDOException $e) {
            die($e->getMessage() . "\n");
        }
	}
}
