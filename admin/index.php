<?
	require_once '../database.php';
	require_once '../functions.php';
	
	session_start();
	if (isset($_POST["delete"])) {
		if (isset($_POST["order"])) {
			$ids = $_POST["order"];
			if (count($ids) > 0) {
				for ($i=0; $i < count($ids); $i++) { 
					deleteOrder($connection, $ids[$i]);
				}
			}
		}

		if (isset($_POST["antis"])) {
			$antis = $_POST["antis"];
			if (count($antis) > 0) {
				for ($i=0; $i < count($antis); $i++) { 
					deleteOrderAI($connection, $antis[$i]);
				}
			}
		}

		if (isset($_POST["oils"])) {
			$oils = $_POST["oils"];
			if (count($oils) > 0) {
				for ($i=0; $i < count($oils); $i++) { 
					deleteOrderOI($connection, $oils[$i]);
				}
			}
		}
	}

	if (isset($_POST["end"])) {
		if (isset($_POST["order"])) {
			$ids = $_POST["order"];
			if (count($ids) > 0) {
				for ($i=0; $i < count($ids); $i++) { 
					endOrder($connection, $ids[$i]);
				}
			}
		}
		
		if (isset($_POST["antis"])) {
			$antis = $_POST["antis"];
			if (count($antis) > 0) {
				for ($i=0; $i < count($antis); $i++) { 
					endOrderAI($connection, $antis[$i]);
				}
			}
		}

		if (isset($_POST["oils"])) {
			$oils = $_POST["oils"];
			if (count($oils) > 0) {
				for ($i=0; $i < count($oils); $i++) { 
					endOrderOI($connection, $oils[$i]);
				}
			} 
		}
	}

	if (isset($_SESSION["login"]) && $_SESSION["type"] == "admin") {
		$sname = $_SESSION["surname"];
		$name = $_SESSION["name"];
		$login = $_SESSION["login"];

		$orders = getOrders($connection);
		$ordersAI = getOrdersAI($connection);
		$ordersOI = getOrdersOI($connection);

		$hide1 = true; $hide2 = true;
		if (count($ordersAI) > 0) {$hide1 = false;}
		if (count($ordersOI) > 0) {$hide2 = false;}
	} else { header('Location: ../'); }

	if (isset($_POST["exit"])) {
		session_destroy();
		header('Location: ../');
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Әкімгер - Autogo</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<header>
		<nav class="navbar navbar-expand navbar-dark">
			<a class="navbar-brand name main-link" href="../">Басты бет</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#items" aria-controls="items" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse " id="items">
				<ul class="nav navbar-nav items ml-auto">
					<li class="nav-item">
						<form action="index.php" method="post"><input type="submit" value="Шығу" name="exit"></form>
					</li>
				</ul>
			</div>
		</nav>
	</header>
	<main>
		<div class="title">Тапсырыстар</div>
		<div class="manage">
			<table>
				<tr>
					<th>ID</th>
					<th>Тегі</th>
					<th>Аты</th>
					<th>Телефон</th>
					<th>Мекен-жай</th>
					<th>Күні</th>
					<th>Сомма</th>
					<th>Статус</th>
					<th></th>
				</tr>
				<? for ($i = 0; $i < count($orders); $i++): ?>
				<tr>
					<td><? echo $orders[$i]["id"]; ?></td>
					<td><? echo $orders[$i]["surname"]; ?></td>
					<td><? echo $orders[$i]["name"]; ?></td>
					<td><? echo $orders[$i]["phone"]; ?></td>
					<td><? echo $orders[$i]["address"]; ?></td>
					<td><? echo $orders[$i]["date"]; ?></td>
					<td><? echo $orders[$i]["sum"]; ?></td>
					<td><? echo $orders[$i]["status"]; ?></td>
					<td><input form="form" type="checkbox" id="<? echo $orders[$i]["id"]; ?>" name="order[]" value="<? echo $orders[$i]["id"]; ?>"></td>
				</tr>
				<? endfor; ?>
			</table>
			
			<div class="title <? if ($hide1) echo "hide"; ?>">Антифриз тапсырыстары</div>
			<table class="<? if ($hide1) echo "hide"; ?>">
				<tr>
					<th>ID</th>
					<th>Тегі</th>
					<th>Аты</th>
					<th>Телефон</th>
					<th>Мекен-жай</th>
					<th>Дата</th>
					<th>Күні</th>
					<th>Статус</th>
					<th></th>
				</tr>
				<? for ($i = 0; $i < count($ordersAI); $i++): ?>
				<tr>
					<td><? echo $ordersAI[$i]["id"]; ?></td>
					<td><? echo $ordersAI[$i]["surname"]; ?></td>
					<td><? echo $ordersAI[$i]["name"]; ?></td>
					<td><? echo $ordersAI[$i]["phone"]; ?></td>
					<td><? echo $ordersAI[$i]["address"]; ?></td>
					<td><? echo $ordersAI[$i]["date"]; ?></td>
					<td><? echo $ordersAI[$i]["sum"]; ?></td>
					<td><? echo $ordersAI[$i]["status"]; ?></td>
					<td><input form="form" type="checkbox" name="antis[]" value="<? echo $ordersAI[$i]["id"]; ?>"></td>
				</tr>
				<? endfor; ?>
			</table>

			<div class="title <? if ($hide2) echo "hide"; ?>">Май тапсырыстары</div>
			<table class="<? if ($hide2) echo "hide"; ?>">
				<tr>
					<th>ID</th>
					<th>Тегі</th>
					<th>Аты</th>
					<th>Телефон</th>
					<th>Мекен-жай</th>
					<th>Күні</th>
					<th>Сомма</th>
					<th>Статус</th>
					<th></th>
				</tr>
				<? for ($i = 0; $i < count($ordersOI); $i++): ?>
				<tr>
					<td><? echo $ordersOI[$i]["id"]; ?></td>
					<td><? echo $ordersOI[$i]["surname"]; ?></td>
					<td><? echo $ordersOI[$i]["name"]; ?></td>
					<td><? echo $ordersOI[$i]["phone"]; ?></td>
					<td><? echo $ordersOI[$i]["address"]; ?></td>
					<td><? echo $ordersOI[$i]["date"]; ?></td>
					<td><? echo $ordersOI[$i]["sum"]; ?></td>
					<td><? echo $ordersOI[$i]["status"]; ?></td>
					<td><input form="form" type="checkbox" name="oils[]" value="<? echo $ordersOI[$i]["id"]; ?>"></td>
				</tr>
				<? endfor; ?>
			</table>
			<hr>
			<form action="index.php" id="form" method="post">
				<input type="submit" name="delete" value="Тапсырысты жою" class="delete">
				<input type="submit" name="end" value="Тапсырысты аяқтау" class="end">
			</form>
		</div>
	</main>
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="../js/bootstrap.min.js"></script>
</body>
</html>