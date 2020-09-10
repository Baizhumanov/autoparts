<?
	require_once '../database.php';
	require_once '../functions.php';

	session_start();
	if (isset($_SESSION["login"])) { header('Location: ../'); }
	if ($_GET["service"] == "login") {
		$title = "Кіру";
	} else {
		$title = "Тіркелу";
		$hide = true;
	}

	if (isset($_POST["login"]) || isset($_POST["password"])) {
		$message = "";
		$login = $_POST["login"];
		$password = $_POST["password"];

		$arrayUsers = getUser($connection, "users", $_POST["login"]);
		if (count($arrayUsers) != 0) { 
			// если вообще есть такой логин
			$passFrom = $arrayUsers[0]["password"];
			if (password_verify($password, $passFrom)) {
				session_destroy();
				ini_set('session.gc_maxlifetime', 10800);
				session_start();
				$_SESSION["login"] = $login;
				$_SESSION["surname"] = $arrayUsers[0]["surname"];
				$_SESSION["name"] = $arrayUsers[0]["name"];
				$_SESSION["type"] = $arrayUsers[0]["type"];

				if ($arrayUsers[0]["type"] == "admin") {
					$_SESSION["type"] = "admin";
					header('Location: ../admin/');
				} else {
					header('Location: ../');
				}
			} else {
				$message = "Логин немесе құпиясөз дұрыс терілмеген";
			}
		} else {
			$message = "Логин немесе құпиясөз дұрыс терілмеген";
		}
	}

	if (isset($_POST["login-reg"]) || isset($_POST["password-reg"])) {
		$message = "";
		$login = htmlspecialchars($_POST["login-reg"]);
		$password = $_POST["password-reg"];
		$hash = password_hash($password, PASSWORD_DEFAULT);
		$surname = htmlspecialchars($_POST["surname"]);
		$name = htmlspecialchars($_POST["name"]);
		$address = htmlspecialchars($_POST["address"]);
		$phone = htmlspecialchars($_POST["phone"]);

		$arrayUsers = getUser($connection, "users", $_POST["login-reg"]);
		if (count($arrayUsers) > 0) {$message = "Осы логин тіркелген, басқа логин теріңіз";}
		else {insertUser($connection, $login, $hash, $surname, $name, $address, $phone);}

		if ($message == "") {
			session_destroy();
			ini_set('session.gc_maxlifetime', 10800);
			session_start();
			$_SESSION["login"] = $login;
			$_SESSION["surname"] = $surname;
			$_SESSION["name"] = $name;
			$_SESSION["type"] = "user";
			header('Location: ../');
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Авторизация - Autogo</title>
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
						<a href="../basket/">Себет</a>
					</li>
				</ul>
			</div>
		</nav>
	</header>
	<main>
		<div class="container">
			<div class="row my-4">
				<div class="col title text-center"><? echo $title; ?></div>
			</div>
		</div>
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-10 col-md-8 col-lg-6">
					<div class="form <? if ($hide) echo "hide"; ?>">
						<form action="index.php?service=login" method="post" onsubmit="return validate('first')">
							<div class="form-group">
								<label for="login">Логин</label>
								<input type="text" name="login" id="login" class="form-control">
							</div>
							<div class="form-group">
								<label for="password">Құпиясөз</label>
								<input type="password" name="password" id="password" class="form-control">
							</div>
							<input type="submit" value="Кіру" class="btn btn-primary btn-block">
							<small class="form-text text-muted">
								Әлі аккаунт жоқ па? <a href="../auth/?service=registration">Тіркеліңіз</a>
							</small>
							<div class="form-group error">
								<? echo "<span>".$message."</span>"; ?>
							</div>
						</form>
					</div>

					<div class="form reg <? if (!$hide) echo "hide"; ?>">
						<form action="index.php?service=registration" method="post" onsubmit="return validate('second')">
							<div class="form-row">
								<div class="form-group col-md-6">
									<label for="login-reg">Логин</label>
									<input type="text" id="login-reg" name="login-reg" class="form-control">
								</div>
								<div class="form-group col-md-6">
									<label for="password-reg">Құпиясөз</label>
									<input type="password" id="password-reg" name="password-reg" class="form-control">
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-6">
									<label for="surname">Тегі</label>
									<input type="text" id="surname" name="surname" class="form-control">
								</div>
								<div class="form-group col-md-6">
									<label for="login">Аты</label>
									<input type="text" id="name" name="name" class="form-control">
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-6">
									<label for="phone">Телефон</label>
									<input type="text" id="phone" name="phone" class="form-control">
								</div>
								<div class="form-group col-md-6">
									<label for="address">Мекен-жай</label>
									<input type="text" id="address" name="address" class="form-control">
								</div>
							</div>
							<input type="submit" value="Тіркелу" class="btn btn-block btn-primary">
							<small class="form-text text-muted">
								Сізде аккаунт бар ма? <a href="../auth/?service=login">Сіз жүйеге кіре аласыз</a>
							</small>
							<div class="form-group error">
								<? echo "<span>".$message."</span>"; ?>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</main>
	<script>
		var surname = document.getElementById("surname");
		var name2 = document.getElementById("name");

		surname.oninput = function() {
			var error = document.getElementById("error-item");
			if (isString(surname.value)) {
				error.innerHTML = "<span>" + "" + "</span>"; 
			} else {
				error.innerHTML = "<span>" + "Тегі тек әріптен тұру қажет" + "</span>";
			}
		};

		name2.oninput = function() {
			var error = document.getElementById("error-item");
			if (isString(name2.value)) {
				error.innerHTML = "<span>" + "" + "</span>"; 
			} else {
				error.innerHTML = "<span>" + "Аты тек әріптен тұру қажет" + "</span>";
			}
		};
		
		// user : Жандаулет+Аслан
		// Если есть варнинг, то удаление с lc
		function validate(form) {
			if (form == "second") {
				var loginReg = document.getElementById("login-reg");
				var passwordReg = document.getElementById("password-reg");
				var surname = document.getElementById("surname");
				var name = document.getElementById("name");
				var message = "";

				if (loginReg.value.trim() == "") {message += "Логин жазылмаған. "}
				if (passwordReg.value.trim() == "") {message += "Құпиясөз жазылмаған. "}
				if (surname.value.trim() == "") {message += "Фамилия жазылмаған. "}
				if (name.value.trim() == "") {message += "Аты жазылмаған. "}

				if (message.length > 0) {
					var error = document.getElementById("error-item");
					error.innerHTML = "<span>" + message + "</span>";
					return false;
				} else {
					return true;
				}
			}
			if (form == "first") {
				var login = document.getElementById("login").value;
				var password = document.getElementById("password").value;
			}
		}

		function isString(s) {
			if (s.match(/[0-9]/)) {
				return false;
			}

 			for (var i = 0; i < s.length; i++) {
				if (s.charAt(i) == "-" || 
					s.charAt(i) == "*" || 
					s.charAt(i) == "(" ||
					s.charAt(i) == ")") {
					return false;
				}
			}
			return true;
		}
	</script>
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="../js/bootstrap.min.js"></script>
</body>
</html>