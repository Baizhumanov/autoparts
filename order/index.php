<?
	require_once '../database.php';
	require_once '../functions.php';

	session_start();
	if (isset($_SESSION["login"])) {
		$sname = $_SESSION["surname"];
		$name = $_SESSION["name"];
		$login = $_SESSION["login"];
		$hide = true;
	}

	if ( isset($_POST["surname"]) || isset($_POST["name"]) ) {
		$sname = htmlspecialchars($_POST["surname"]); // Ненужные данные
		$name = htmlspecialchars($_POST["name"]); // Ненужные данные
		$phone = htmlspecialchars($_POST["phone"]);
		$address = htmlspecialchars($_POST["address"]);
		$hide = $_POST["parts"];
		$antis = $_POST["antis"];
		$oils = $_POST["oils"];
		$sum = $_POST["sum"];
		$sum2 = $_POST["sum-ai"];
		$sum3 = $_POST["sum-oi"];
		if (strlen($hide) > 1 || strlen($antis) > 1 || strlen($oils) > 1) {
			// insertOrderAI($link, $login, $phone, $address, $sum, $antis)
			if (strlen($hide) > 1) {insertOrder($connection, $login, $phone, $address, $sum, $hide);}
			if (strlen($antis) > 1) {insertOrderAI($connection, $login, $phone, $address, $sum2, $antis);}
			if (strlen($oils) > 1) {insertOrderOI($connection, $login, $phone, $address, $sum3, $oils);}
			$hasOrder = true;
		} else {
			$message = "Ешқандай тауар таңдалмаған";
			$hasOrder = false;
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Тапсырыс - Autogo</title>
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
						<a href="../user/?login=<? echo $login; ?>" class="<? if (!$hide) echo "hide"; ?>">Жеке бөлме</a>
					</li>
				</ul>
			</div>
		</nav>
	</header>
	<main>
		<div class="container">
			<div class="row my-5">
				<div class="col title text-center" id="title">
					<?
						if ($hasOrder) {
							echo "Тапсырыс жіберілді";
						} else if ($message) {
							echo $message;
						} else {
							echo "Сіздің таңдаған тауарларыңыз";
						}
					?>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="row <? if ($hasOrder || $message) echo "hide"; ?>" id="grid"></div>
			<div class="row my-1">
				<div class="title col text-center" id="title-ai">Антифриз</div>
			</div>
			<div class="row <? if ($hasOrder || $message) echo "hide"; ?>" id="grid-2"></div>
			<div class="row my-1">
				<div class="title col text-center" id="title-oi">Май</div>
			</div>
			<div class="row <? if ($hasOrder || $message) echo "hide"; ?>" id="grid-3"></div>
		</div>
		<!-- 
		<div class="grid " id="grid"></div> -->

		
		<!-- <div class="grid <? //if ($hasOrder || $message) echo "hide"; ?>" id="grid-2"></div> -->

		
		<!-- <div class="grid <? //if ($hasOrder || $message) echo "hide"; ?>" id="grid-3"></div> -->

		<div class="container-fluid form-bg <? if ($hasOrder || $message) echo "hide"; ?>" id="form-bg">
			<div class="row my-3">
				<div class="col text-center title">Сауалнама</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-10 col-md-8 col-lg-6 <? if ($hide) echo "hide"; ?> card p-5">
					<div class="explain">Тапсырысты беру үшін, алдымен жүйеге кіріңіз немесе тіркеліңіз</div>
					<br>
					<a href="../auth/?service=login" class="btn btn-block btn-primary btn-lg">Жүйеге кіру</a>
					<br>
					<a href="../auth/?service=registration" class="btn btn-block btn-outline-primary btn-lg">Тіркелу</a>
					<br>
					<div class="explain">Таңдалған бөлшектер <b>жойылмайды</b></div>
				</div>
				<div class="col-10 col-md-8 col-lg-6 <? if (!$hide) echo "hide"; ?> card p-5">
					<form class="ted <? if (!$hide) echo "hide"; ?>" action="index.php" id="buy" onsubmit="return validate()" method="post">
						<input type="hidden" name="sum" value="0" id="sum">
						<input type="hidden" name="sum-ai" value="0" id="sum-ai">
						<input type="hidden" name="sum-oi" value="0" id="sum-oi">
						<input type="hidden" name="parts" value="" id="parts">
						<input type="hidden" name="antis" value="" id="antis">
						<input type="hidden" name="oils" value="" id="oils">
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="surname">Тегі</label><br>
								<input type="text" id="surname" value="<? if ($hide) echo $sname; ?>" name="surname"  class="form-control">
							</div>
							<div class="form-group col-md-6">
								<label for="name">Аты</label><br>
								<input type="text" id="name" value="<? if ($hide) echo $name; ?>" name="name"  class="form-control">
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="phone">Телефон нөмірі</label><br>
								<input type="text" id="phone" name="phone" class="form-control">
							</div>
							<div class="form-group col-md-6">
								<label for="address">Мекен-жай</label><br>
								<input type="text" id="address" name="address" class="form-control">
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-6">
								<a class="btn-link" href="../user/?login=<? echo $login; ?>">Аккаунт ауыстыру (таңдалған бөлшектер <b>жоғалмайды</b>)</a>
							</div>
							<div class="form-group col-md-6">
								<input type="submit" value="Тапсырыс беру" class="btn btn-block btn-primary">
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col error" id="error-item"></div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</main>
	<script>
		// Проверка на то, выбран ли хоть какой-то товар
		if (localStorage.length == 0) {
			document.getElementById("title").textContent = "Ешқандай тауар таңдалмаған";
			document.getElementById("form-bg").className = "form-bg hide";
		}

		// Очистка корзины после покупки
		if (document.getElementById("title").textContent.trim() == "Тапсырыс жіберілді") {	localStorage.clear(); }

		var grid = document.getElementById("grid");
		var grid2 = document.getElementById("grid-2");
		var grid3 = document.getElementById("grid-3");
		var formBuy = document.getElementById("buy");
		var sumHidden = document.getElementById("sum");
		var sumHidden2 = document.getElementById("sum-ai");
		var sumHidden3 = document.getElementById("sum-oi");
		var hidden = "";
		var hideGrid1 = true;
		var hideTitle2 = true;
		var hideTitle3 = true;

		for (var i = 0; i < localStorage.length; i++) {
			var key = localStorage.key(i);
			if (key.slice(0, 3) == "ai-") {hideTitle2 = false; continue;}
			if (key.slice(0, 3) == "oi-") {hideTitle3 = false; continue;}
			hideGrid1 = false;
			var value = localStorage.getItem(key);

			var first = value.indexOf("+");
			var second = value.indexOf("+", first + 1);

			var priceText = value.slice(second + 1);
			var countText = value.slice(0, first);
			var nameText = value.slice(first + 1, second).replace(/_/g, ' ');

			var item = createEl("selected item");
			item.id = key.slice(3);

			var nameItem = createEl("name", nameText);
			var content = createEl("content");

			var price = createEl("price", "Бағасы: " + priceText);
			var count = createEl("count");
			count.appendChild(createCount("-", item.id));
			var text = createEl("text", countText);
			count.appendChild(text);
			count.appendChild(createCount("+", item.id));
			var sum = createEl("sum", countText * priceText);

			content.appendChild(price);
			content.appendChild(count);
			content.appendChild(sum);

			item.appendChild(nameItem);
			item.appendChild(content);

			var template = createEl("col-10 col-sm-6 col-md-4 col-lg-3");
			template.appendChild(item);
			grid.appendChild(template);

			sumHidden.value = Number.parseInt(sumHidden.value) + (priceText * countText);
		}

		for (var i = 0; i < localStorage.length; i++) {
			var key = localStorage.key(i);
			if (key.slice(0, 3) != "ai-") { continue;}
			var value = localStorage.getItem(key);

			var first = value.indexOf("+");
			var second = value.indexOf("+", first + 1);

			var priceText = value.slice(second + 1);
			var countText = value.slice(0, first);
			var nameText = value.slice(first + 1, second).replace(/_/g, ' ');

			var item = createEl("selected item");
			item.id = key;  // ai-5

			var nameItem = createEl("name", nameText);
			var content = createEl("content");

			var price = createEl("price", "Бағасы: " + priceText);
			var count = createEl("count");
			count.appendChild(createCount("-", item.id));
			var text = createEl("text", countText);
			count.appendChild(text);
			count.appendChild(createCount("+", item.id));
			var sum = createEl("sum", countText * priceText);

			content.appendChild(price);
			content.appendChild(count);
			content.appendChild(sum);

			item.appendChild(nameItem);
			item.appendChild(content);

			var template = createEl("col-10 col-sm-6 col-md-4 col-lg-3");
			template.appendChild(item);
			grid2.appendChild(template);

			sumHidden2.value = Number.parseInt(sumHidden2.value) + (priceText * countText);
		}

		for (var i = 0; i < localStorage.length; i++) {
			var key = localStorage.key(i);
			if (key.slice(0, 3) != "oi-") { continue;}
			var value = localStorage.getItem(key);

			var first = value.indexOf("+");
			var second = value.indexOf("+", first + 1);

			var priceText = value.slice(second + 1);
			var countText = value.slice(0, first);
			var nameText = value.slice(first + 1, second).replace(/_/g, ' ');

			var item = createEl("selected item");
			item.id = key;  // oi-5

			var nameItem = createEl("name", nameText);
			var content = createEl("content");

			var price = createEl("price", "Бағасы: " + priceText);
			var count = createEl("count");
			count.appendChild(createCount("-", item.id));
			var text = createEl("text", countText);
			count.appendChild(text);
			count.appendChild(createCount("+", item.id));
			var sum = createEl("sum", countText * priceText);

			content.appendChild(price);
			content.appendChild(count);
			content.appendChild(sum);

			item.appendChild(nameItem);
			item.appendChild(content);

			var template = createEl("col-10 col-sm-6 col-md-4 col-lg-3");
			template.appendChild(item);
			grid3.appendChild(template);

			sumHidden3.value = Number.parseInt(sumHidden3.value) + (priceText * countText);
		}

		checkParts("grid");
		checkParts("grid-2");
		checkParts("grid-3");

		if (hideGrid1) { grid.className = "grid hide"; }
		if (hideTitle2) {
			document.getElementById("title-ai").className = "title hide";
			grid2.className = "grid hide";
		}
		if (hideTitle3) {
			document.getElementById("title-oi").className = "title hide";
			grid3.className = "grid hide";
		}

		function createCount(o, id) {
			var button = document.createElement("button");
			button.addEventListener("click", function() {onClick(id, o);});
			var img = document.createElement("img");
			img.src = (o == "-") ? "../icons/minus.svg" : "../icons/plus.svg";
			button.appendChild(img);
			return button;
		}

		function createEl(className, text) {
			if (text == undefined) text = "";
			var div = document.createElement("div");
			div.className = className;
			var node = document.createTextNode(text);
			div.appendChild(node);
			return div;
		}

		function onClick(id, o) {
			// o = operation
			var item = document.getElementById(id);
			var content = item.children[1];
			var textElement = content.children[1].getElementsByClassName("text");
			var sum = content.children[2];

			var text = textElement[0].textContent; // кол-во
			var name = item.children[0].textContent.replace(/ /g, '_');
			var price = content.children[0].textContent.slice(8); // цена

			if (o == "-") {
				if (text > 0) {
					text--;
					sum.textContent = text * price;
					textElement[0].textContent = text;
					if (text == 0) {
						if (id.slice(0, 1) == "a" || id.slice(0, 1) == "o") {
							localStorage.removeItem(id);
						} else {
							localStorage.removeItem("el-" + id);
						}
						item.className = "item";
					} else {
						if (id.slice(0, 1) == "a" || id.slice(0, 1) == "o") {
							localStorage.setItem(id, text + "+" + name + "+" + price);
						} else {
							localStorage.setItem("el-" + id, text + "+" + name + "+" + price);
						}
					}
				}
			} else {
				if (text != 10) {
					text++;
					sum.textContent = text * price;
					textElement[0].textContent = text;
				}
				item.className = "selected item";
				if (id.slice(0, 1) == "a" || id.slice(0, 1) == "o") {
					localStorage.setItem(id, text + "+" + name + "+" + price);
				} else {
					localStorage.setItem("el-" + id, text + "+" + name + "+" + price);
				}
			}
			if (id.slice(0, 1) == "a") {
				checkSum("grid-2");
				checkParts("grid-2");
			} else if (id.slice(0, 1) == "o") {
				checkSum("grid-3");
				checkParts("grid-3");
			} else {
				checkSum("grid");
				checkParts("grid");
			}
		}

		function validate() {
			var surname = document.getElementById("surname");
			var name = document.getElementById("name");
			var phone = document.getElementById("phone");
			var address = document.getElementById("address");
			var message = "";

			if (surname.value.trim() == "") {message += "Фамилия жазылмаған. "}
			if (name.value.trim() == "") {message += "Аты жазылмаған. "}
			if (phone.value.trim() == "") {message += "Телефон нөмірі жазылмаған. "}
			if (address.value.trim() == "") {message += "Адрес жазылмаған. "}

			if (message.length > 0) {
				var error = document.getElementById("error-item");
				error.innerHTML = "<span>" + message + "</span>";
				return false;
			} else {
				return true;
			}
		}

		function checkSum(grid) {
			var sums = document.getElementById(grid).getElementsByClassName("sum");
			var sum = 0;
			for (var i = 0; i < sums.length; i++) {
				sum += Number.parseInt(sums[i].textContent);
			}

			switch(grid) {
				case 'grid': document.getElementById("sum").value = sum; break;
				case 'grid-2': document.getElementById("sum-ai").value = sum; break;
				case 'grid-3': document.getElementById("sum-oi").value = sum; break;
			}
		}

		function checkParts(grid) {
			var text = "";
			var len = 0;
			for (var i = 0; i < localStorage.length; i++) {
				var key = localStorage.key(i);
				if (grid == "grid-2") {
					if (key.slice(0, 3) != "ai-") { continue; }
				} else if (grid == "grid-3") {
					if (key.slice(0, 3) != "oi-") { continue; }
				} else {
					if (key.slice(0, 3) != "el-") { continue; }
				}
				var value = localStorage.getItem(key);

				var countText = value.slice(0, value.indexOf("+"));
				var id = key.slice(3);
				text += id + "_" + countText + "+";
				len++;
			}
			if (len == 0) text = " ";

			switch(grid) {
				case 'grid': document.getElementById("parts").value = text; break;
				case 'grid-2': document.getElementById("antis").value = text; break;
				case 'grid-3': document.getElementById("oils").value = text; break;
			}
		}
	</script>
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="../js/bootstrap.min.js"></script>
</body>
</html>