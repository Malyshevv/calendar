<?php

include ('config.php');

class MainClass {

	function addData($nameEvent,$location,$dataStart,$dataEnd,$phone) {
		$ip = $_SERVER['REMOTE_ADDR'];

		$query = "INSERT INTO calendar(event_name,location,dataStart,dataEnd,phone,ip) VALUES ('$nameEvent', '$location', '$dataStart', '$dataEnd','$phone', '$ip')";
		$add = $this->connect->real_query($query);
		
		if($add) {
			echo json_encode(array('result'=>'success'));
		}
		else {
			echo json_encode(array('result'=>'no'));
		}
	}

	function updateData($idEdit,$nameEventUpdate,$locationUpdate,$dataStartUpdate,$dataEndUpdate,$phoneUpdate) {
		$query     = "UPDATE calendar SET event_name = '$nameEventUpdate',
										 location = '$locationUpdate',
										 dataStart = '$dataStartUpdate',
										 dataEnd = '$dataEndUpdate',
										 phone = '$phoneUpdate' WHERE id='$idEdit'";
		$result = $this->connect->real_query($query);
		if ($result) {
			#echo $query;
			echo json_encode(array('result'=>'success'));
		}
		else {
			#echo $query;
			echo json_encode(array('result'=>'no'));
		}		
	}

	function delitData($idDelit) {
		$sql = "DELETE FROM calendar WHERE id='$idDelit'";
		$query = $this->connect->real_query($sql);
	}

	function DataView() {
		$sql = "SELECT * FROM calendar ORDER BY id DESC";
		$query = $this->connect->query($sql);
		$store = $this->connect->store_result();

		while ($row = $query->fetch_assoc()) {
			$list[] = $row;
		}

		return $list;
	}
}

if(isset($_POST['idEdit']) && isset($_POST['nameEventUpdate']) && isset($_POST['locationUpdate']) && isset($_POST['dataStartUpdate']) && isset($_POST['dataEndUpdate']) && isset($_POST['phoneUpdate'])) {
	if(empty($_POST['idEdit']) && empty($_POST['nameEventUpdate']) && empty($_POST['locationUpdate']) && empty($_POST['dataStartUpdate']) && empty($_POST['dataEndUpdate']) && empty($_POST['phoneUpdate'])) {
		echo json_encode(array('result'=>'error'));
	}
	else {
		$phoneUpdate = (string)$_POST['phoneUpdate'];
		$idEdit = (int)$_POST['idEdit'];
		$nameEventUpdate = (string)$_POST['nameEventUpdate'];
		$locationUpdate = (string)$_POST['locationUpdate'];
		$dataStartUpdate = (string)$_POST['dataStartUpdate'];
		$dataEndUpdate = (string)$_POST['dataEndUpdate'];
		
		$main->updateData($idEdit,$nameEventUpdate,$locationUpdate,$dataStartUpdate,$dataEndUpdate,$phoneUpdate);
	}
}



if(isset($_POST['name']) && isset($_POST['location']) && isset($_POST['dataStart']) && isset($_POST['dataEnd']) && isset($_POST['phone'])) {
	if(empty($_POST['name']) && empty($_POST['location']) && empty($_POST['dataStart']) && empty($_POST['dataEnd']) && empty($_POST['phone'])) {
		echo json_encode(array('result'=>'error'));
	}
	else {
		$phone = (string)$_POST['phone'];
		$nameEvent = (string)$_POST['name'];
		$location = (string)$_POST['location'];
		$dataStart = (string)$_POST['dataStart'];
		$dataEnd = (string)$_POST['dataEnd'];
		
		$main->addData($nameEvent,$location,$dataStart,$dataEnd,$phone);
	}
}

if(isset($_POST['idDelit'])) {
	if(empty($_POST['idDelit'])) {
		echo json_encode(array('result'=>'error'));
	}
	else {
		$idDelit = (int)$_POST['idDelit'];
		$main->delitData($idDelit);
	}
}

$data = $main->DataView();

?>