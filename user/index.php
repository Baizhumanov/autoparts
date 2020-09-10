<?
	require_once '../database.php';
	require_once '../functions.php';
	session_start();
	if (isset($_SESSION["login"])) {
		if ($_SESSION["login"] == $_GET["login"]) {
			$sname = $_SESSION["surname"];
			$name = $_SESSION["name"];
			$login = $_SESSION["login"];

			$orders = getUserOrders($connection, $login);
			$orderAI = getUserOrdersAI($connection, $login);
			$orderOI = getUserOrdersOI($connection, $login);
		} else { header('Location: ../'); }
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
	<title>Профиль - Autogo</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<header>
		<nav class="navbar navbar-expand-md navbar-toggleable navbar-dark">
			<a class="navbar-brand name main-link" href="../">Басты бет</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#items" aria-controls="items" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse " id="items">
				<ul class="nav navbar-nav items ml-auto">
					<li class="nav-item">
						<a href="../basket/">Себет</a>
					</li>
					<li class="nav-item">
						<form action="index.php" method="post"><input type="submit" value="Шығу" name="exit"></form>
					</li>
				</ul>
			</div>
		</nav>
	</header>
	<main>
		<div class="container">
			<div class="row">
				<div class="col title"><? echo $sname." ".$name; ?></div>
			</div>
		</div>

		<? for ($i = 0; $i < count($orders); $i++): ?>
		<div class="containers">
			<div class="data">
				<b>Тегі:</b> <? echo $sname; ?> <br>
				<b>Аты:</b> <? echo $name; ?> <br>
				<b>Телефон нөмірі:</b> <? echo $orders[$i]["phone"]; ?> <br>
				<b>Мекен-жай:</b> <? echo $orders[$i]["address"]; ?> <br>
				<b>Күні:</b> <? echo $orders[$i]["date"]; ?> <br>
				<b>Сомма:</b> <? echo $orders[$i]["sum"]; ?> <br>
				<b>Статус:</b> <? echo $orders[$i]["status"]; ?> <br>
			</div>
			<? $parts = getOrderParts($connection, $orders[$i]["id"]); ?>
			<div class="parts">
				<table>
					<th>Бөлшек атауы</th>
					<th>Саны</th>
					<? for ($j = 0; $j < count($parts); $j++): ?>
					<tr>
						<td><? echo $parts[$j]["name"]; ?></td>
						<td class="tac"><? echo $parts[$j]["count"]; ?></td>
					</tr>
					<? endfor; ?>
				</table>
			</div>
		</div>
		<? endfor; ?>

		<? for ($i = 0; $i < count($orderAI); $i++): ?>
		<div class="containers">
			<div class="data">
				<b>Тегі:</b> <? echo $sname; ?> <br>
				<b>Аты:</b> <? echo $name; ?> <br>
				<b>Телефон нөмірі:</b> <? echo $orderAI[$i]["phone"]; ?> <br>
				<b>Мекен-жай:</b> <? echo $orderAI[$i]["address"]; ?> <br>
				<b>Күні:</b> <? echo $orderAI[$i]["date"]; ?> <br>
				<b>Сомма:</b> <? echo $orderAI[$i]["sum"]; ?> <br>
				<b>Статус:</b> <? echo $orderAI[$i]["status"]; ?> <br>
			</div>
			<? $antis = getOrderAntis($connection, $orderAI[$i]["id"]); ?>
			<div class="parts">
				<table>
					<th>Антифриз атауы</th>
					<th>Саны</th>
					<? for ($j = 0; $j < count($antis); $j++): ?>
					<tr>
						<td><? echo $antis[$j]["name"]; ?></td>
						<td class="tac"><? echo $antis[$j]["count"]; ?></td>
					</tr>
					<? endfor; ?>
				</table>
			</div>
		</div>
		<? endfor; ?>

		<? for ($i = 0; $i < count($orderOI); $i++): ?>
		<div class="containers">
			<div class="data">
				<b>Тегі:</b> <? echo $sname; ?> <br>
				<b>Аты:</b> <? echo $name; ?> <br>
				<b>Телефон нөмірі:</b> <? echo $orderOI[$i]["phone"]; ?> <br>
				<b>Мекен-жай:</b> <? echo $orderOI[$i]["address"]; ?> <br>
				<b>Күні:</b> <? echo $orderOI[$i]["date"]; ?> <br>
				<b>Сомма:</b> <? echo $orderOI[$i]["sum"]; ?> <br>
				<b>Статус:</b> <? echo $orderOI[$i]["status"]; ?> <br>
			</div>
			<? $oils = getOrderOils($connection, $orderOI[$i]["id"]); ?>
			<div class="parts">
				<table>
					<th>Май атауы</th>
					<th>Саны</th>
					<? for ($j = 0; $j < count($oils); $j++): ?>
					<tr>
						<td><? echo $oils[$j]["name"]; ?></td>
						<td class="tac"><? echo $oils[$j]["count"]; ?></td>
					</tr>
					<? endfor; ?>
				</table>
			</div>
		</div>
		<? endfor; ?>
	</main>
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="../js/bootstrap.min.js"></script>
</body>
</html>