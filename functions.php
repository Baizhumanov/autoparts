<?
	function get_main($link, $table_name) {
		$sql = "SELECT * FROM $table_name";
		$result = mysqli_query($link, $sql);
		$main = mysqli_fetch_all($result, MYSQLI_ASSOC);
		return $main;
	}

	function getParts($link, $table_name, $car) {
		$sql = "SELECT * FROM $table_name WHERE mark = '".$car."' ORDER BY `group`";
		$result = mysqli_query($link, $sql);
		$main = mysqli_fetch_all($result, MYSQLI_ASSOC);
		return $main;
	}

	function getAccess($link) {
		$sql = "SELECT * FROM parts WHERE `group` = 'access'";
		$result = mysqli_query($link, $sql);
		$main = mysqli_fetch_all($result, MYSQLI_ASSOC);
		return $main;
	}

	function getAntifreeze($link) {
		$sql = "SELECT * FROM antifreeze";
		$result = mysqli_query($link, $sql);
		$main = mysqli_fetch_all($result, MYSQLI_ASSOC);
		return $main;
	}

	function getOils($link) {
		$sql = "SELECT * FROM oils";
		$result = mysqli_query($link, $sql);
		$main = mysqli_fetch_all($result, MYSQLI_ASSOC);
		return $main;
	}

	function getGroups($link, $car) {
		$sql = "SELECT DISTINCT `group` FROM `parts` WHERE mark = '".$car."' ORDER BY `group`";
		$result = mysqli_query($link, $sql);
		$main = mysqli_fetch_all($result, MYSQLI_ASSOC);
		return $main;
	}

	function getUser($link, $table_name, $user) {
		$sql = "SELECT `login`, `password`, `surname`, `name`, `type` FROM $table_name WHERE login = '".$user."'";
		$result = mysqli_query($link, $sql);
		$main = mysqli_fetch_all($result, MYSQLI_ASSOC);
		return $main;
	}

	function insertUser($link, $login, $pass, $sname, $name, $address, $phone) {
		$sql = "INSERT INTO users (login, password, surname, name, address, phone, type) VALUES (\"$login\", \"$pass\", \"$sname\", \"$name\", \"$address\", \"$phone\", \"user\")";
		$result = mysqli_query($link, $sql);
	}

	function insertOrder($link, $login, $phone, $address, $sum, $parts) {
		$arrayUserId = getUserId($link, $login);
		$id = $arrayUserId[0]["id"];

		$date = date("Y-m-d");
		$sql = "INSERT INTO orders (id_user, phone, address, `date`, `sum`, status) VALUES (\"$id\", \"$phone\", \"$address\", \"$date\", \"$sum\", \"Тапсырыс\")";
		$result = mysqli_query($link, $sql);

		$order_id = mysqli_insert_id($link);
		$arr = explode('+', $parts);
		// substr_count($parts, '+');
		for ($i = 0; $i < count($arr) - 1; $i++) { 
			$indexOfSep = strpos($arr[$i], '_');
			$part_id = substr($arr[$i], 0, strlen($arr[$i]) - $indexOfSep);
			$count = substr($arr[$i], $indexOfSep + 1);
			$sql = "INSERT INTO ordersparts (order_id, part_id, count) VALUES ($order_id, \"$part_id\", \"$count\")";
			$result = mysqli_query($link, $sql);
		}
	}

	function insertOrderAI($link, $login, $phone, $address, $sum, $antis) {
		$arrayUserId = getUserId($link, $login);
		$id = $arrayUserId[0]["id"];

		$date = date("Y-m-d");
		$sql = "INSERT INTO ordersanti (user_id, phone, address, `date`, `sum`, status) VALUES (\"$id\", \"$phone\", \"$address\", \"$date\", \"$sum\", \"Тапсырыс\")";
		$result = mysqli_query($link, $sql);

		$order_id = mysqli_insert_id($link);
		$arr = explode('+', $antis);
		// substr_count($parts, '+');
		for ($i = 0; $i < count($arr) - 1; $i++) { 
			$indexOfSep = strpos($arr[$i], '_');
			$anti_id = substr($arr[$i], 0, strlen($arr[$i]) - $indexOfSep);
			$count = substr($arr[$i], $indexOfSep + 1);
			$sql = "INSERT INTO ordersantis VALUES ($order_id, \"$anti_id\", \"$count\")";
			$result = mysqli_query($link, $sql);
		}
	}

	function insertOrderOI($link, $login, $phone, $address, $sum, $oils) {
		$arrayUserId = getUserId($link, $login);
		$id = $arrayUserId[0]["id"];

		$date = date("Y-m-d");
		$sql = "INSERT INTO ordersoil (user_id, phone, address, `date`, `sum`, status) VALUES (\"$id\", \"$phone\", \"$address\", \"$date\", \"$sum\", \"Тапсырыс\")";
		$result = mysqli_query($link, $sql);

		$order_id = mysqli_insert_id($link);
		$arr = explode('+', $oils);
		// substr_count($parts, '+');
		for ($i = 0; $i < count($arr) - 1; $i++) { 
			$indexOfSep = strpos($arr[$i], '_');
			$oil_id = substr($arr[$i], 0, strlen($arr[$i]) - $indexOfSep);
			$count = substr($arr[$i], $indexOfSep + 1);
			$sql = "INSERT INTO ordersoils VALUES ($order_id, \"$oil_id\", \"$count\")";
			$result = mysqli_query($link, $sql);
		}
	}

	function getUserId($link, $login) {
		$sql = "SELECT `id` FROM users WHERE login = '".$login."'";
		$result = mysqli_query($link, $sql);
		$main = mysqli_fetch_all($result, MYSQLI_ASSOC);
		return $main;
	}

	function getUserOrders($link, $login) {
		$arrayUserId = getUserId($link, $login);
		$id = $arrayUserId[0]["id"];

		$sql = "SELECT * FROM orders WHERE id_user = '".$id."' ORDER BY `date` DESC";
		$result = mysqli_query($link, $sql);
		$main = mysqli_fetch_all($result, MYSQLI_ASSOC);
		return $main;
	}

	function getUserOrdersAI($link, $login) {
		$arrayUserId = getUserId($link, $login);
		$id = $arrayUserId[0]["id"];

		$sql = "SELECT * FROM ordersanti WHERE user_id = '".$id."' ORDER BY `date` DESC";
		$result = mysqli_query($link, $sql);
		$main = mysqli_fetch_all($result, MYSQLI_ASSOC);
		return $main;
	}

	function getUserOrdersOI($link, $login) {
		$arrayUserId = getUserId($link, $login);
		$id = $arrayUserId[0]["id"];

		$sql = "SELECT * FROM ordersoil WHERE user_id = '".$id."' ORDER BY `date` DESC";
		$result = mysqli_query($link, $sql);
		$main = mysqli_fetch_all($result, MYSQLI_ASSOC);
		return $main;
	}

	function getOrderParts($link, $id) {
		$sql = "SELECT `parts`.`name`, `ordersparts`.`count` FROM ordersparts INNER JOIN parts ON `ordersparts`.`part_id` = `parts`.`id` WHERE order_id = '".$id."'";
		$result = mysqli_query($link, $sql);
		$main = mysqli_fetch_all($result, MYSQLI_ASSOC);
		return $main;
	}

	function getOrderAntis($link, $id) {
		$sql = "SELECT `antifreeze`.`name`, `ordersantis`.`count` FROM ordersantis INNER JOIN antifreeze ON `ordersantis`.`anti_id` = `antifreeze`.`id` WHERE order_id = '".$id."'";
		$result = mysqli_query($link, $sql);
		$main = mysqli_fetch_all($result, MYSQLI_ASSOC);
		return $main;
	}

	function getOrderOils($link, $id) {
		$sql = "SELECT `oils`.`name`, `ordersoils`.`count` FROM ordersoils INNER JOIN oils ON `ordersoils`.`oil_id` = `oils`.`id` WHERE order_id = '".$id."'";
		$result = mysqli_query($link, $sql);
		$main = mysqli_fetch_all($result, MYSQLI_ASSOC);
		return $main;
	}

	function getOrders($link) {
		$sql = "SELECT orders.id, users.surname, users.name, orders.phone, orders.address, orders.`date`, orders.sum, orders.status FROM orders INNER JOIN users ON orders.`id_user` = `users`.`id` WHERE status = 'Тапсырыс'";
		$result = mysqli_query($link, $sql);
		$main = mysqli_fetch_all($result, MYSQLI_ASSOC);
		return $main;
	}

	function getOrdersAI($link) {
		$sql = "SELECT ordersanti.id, users.surname, users.name, ordersanti.phone, ordersanti.address, ordersanti.`date`, ordersanti.sum, ordersanti.status FROM ordersanti INNER JOIN users ON ordersanti.`user_id` = `users`.`id` WHERE status = 'Тапсырыс'";
		$result = mysqli_query($link, $sql);
		$main = mysqli_fetch_all($result, MYSQLI_ASSOC);
		return $main;
	}

	function getOrdersOI($link) {
		$sql = "SELECT ordersoil.id, users.surname, users.name, ordersoil.phone, ordersoil.address, ordersoil.`date`, ordersoil.sum, ordersoil.status FROM ordersoil INNER JOIN users ON ordersoil.`user_id` = `users`.`id` WHERE status = 'Тапсырыс'";
		$result = mysqli_query($link, $sql);
		$main = mysqli_fetch_all($result, MYSQLI_ASSOC);
		return $main;
	}

	function deleteOrder($link, $id) {
		$sql = "DELETE FROM orders WHERE id = '".$id."'";
		$result = mysqli_query($link, $sql);
		$sql = "DELETE FROM ordersparts WHERE order_id = '".$id."'";
		$result = mysqli_query($link, $sql);
	}

	function deleteOrderAI($link, $id) {
		$sql = "DELETE FROM ordersanti WHERE id = '".$id."'";
		$result = mysqli_query($link, $sql);
		$sql = "DELETE FROM ordersantis WHERE order_id = '".$id."'";
		$result = mysqli_query($link, $sql);
	}

	function deleteOrderOI($link, $id) {
		$sql = "DELETE FROM ordersoil WHERE id = '".$id."'";
		$result = mysqli_query($link, $sql);
		$sql = "DELETE FROM ordersoils WHERE order_id = '".$id."'";
		$result = mysqli_query($link, $sql);
	}

	function endOrder($link, $id) {
		$sql = "UPDATE orders SET status = 'Тапсырылды' WHERE id = '".$id."'";
		$result = mysqli_query($link, $sql);
	}

	function endOrderAI($link, $id) {
		$sql = "UPDATE ordersanti SET status = 'Тапсырылды' WHERE id = '".$id."'";
		$result = mysqli_query($link, $sql);
	}

	function endOrderOI($link, $id) {
		$sql = "UPDATE ordersoil SET status = 'Тапсырылды' WHERE id = '".$id."'";
		$result = mysqli_query($link, $sql);
	}
?>