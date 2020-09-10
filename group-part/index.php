<?
	require_once '../database.php';
	require_once '../functions.php';
	$main = getParts($connection, $table_name, $_GET["name"]);
	$main2 = getGroups($connection, $_GET["name"]);
	// echo "<pre>";
	// echo var_dump($main);
	// echo "</pre>";
	session_start();
	if (isset($_SESSION["login"])) {
		$sname = $_SESSION["surname"];
		$name = $_SESSION["name"];
		$login = $_SESSION["login"];
		$hide = true;
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Бөлшектер - Autogo</title>
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

			<div class="collapse navbar-collapse" id="items">
				<ul class="nav navbar-nav items ml-auto">
					<li class="nav-item">
						<a href="../basket/">Себет</a>
					</li>
					<li class="nav-item">
						<a href="../user/?login=<? echo $login; ?>" class="<? if (!$hide) echo "hide"; ?>">Жеке бөлме</a>
					</li>
					<li class="nav-item <? if ($hide) echo "hide"; ?>">
						<a href="../auth/?service=login" class="login <? if ($hide) echo "hide"; ?>">Кіру</a>
					</li>
					<li class="nav-item button <? if ($hide) echo "hide"; ?>">
						<a href="../auth/?service=registration" class="reg <? if ($hide) echo "hide"; ?>">Тіркелу</a>
					</li>
				</ul>
			</div>
		</nav>
	</header>
	<main>
		<div class="container">
			<div class="row my-4">
				<div class="col auto text-center"><? echo ucfirst($_GET["name"]); ?>-ға арналған автобөлшектер</div>
			</div>
		</div>
		
		<div class="container">
			<? for ($i = 0; $i < count($main2); $i++): ?>
			<div class="row" id="group-<? echo $i+1 ?>">
				<div class="col"><div class="title"><? echo $main2[$i]["group"]; ?></div></div>
				<div class="w-100"></div>
				<?
					static $j = 0;
					while ($main[$j]["group"] == $main2[$i]["group"]): 
				?>
				<div class="col-10 col-sm-6 col-md-4 col-lg-3">
					<div class="item" id="<? echo $main[$j]["Id"] ?>">
						<div class="name"><? echo $main[$j]["name"]; ?></div>
						<div class="content">
							<div class="price">Бағасы: <? echo $main[$j]["price"]; ?></div>
							<div class="count">
								<button onclick="onClick(<? echo $main[$j]["Id"] ?>, '-')"><img src="../icons/minus.svg"></button>
								<div class="text">0</div>
								<button onclick="onClick(<? echo $main[$j]["Id"] ?>, '+')"><img src="../icons/plus.svg"></button>
							</div>
							<div class="sum">0</div>
						</div>
					</div>
				</div>
				<? $j++; endwhile; ?>
			</div>
			<div class="row">
				<hr class="col">
			</div>
			<? endfor; ?>
		</div>
		
		<div class="container">
			<div class="row justify-content-between py-5">
				<div class="col-6 col-md-4">
					<div class="label">
						<div class="main-count" id="main-count">Таңдалған тауарлар саны: 0</div>
						<div class="main-sum" id="main-sum">Сомма: 0</div>
					</div>
				</div>
				<div class="col-6 col-md-4">
					<a href="../order/" class="btn btn-primary btn-lg">Ары қарай</a>
				</div>
			</div>
		</div>
	</main>

	<script>
		var mainSum = 0;
		var mainCount = 0;
		for (var i = 1; i <= <? echo count($main2); ?>; i++) {
			var returns = onLoad("group-" + i);
			mainSum += Number.parseInt(returns[0]);
			mainCount += Number.parseInt(returns[1]);
		}
		document.getElementById("main-sum").textContent = "Сомма: " + mainSum;
		document.getElementById("main-count").textContent = "Таңдалған тауарлар саны: " + mainCount;

		function onClick(id, o) {
			// o = operation
			var item = document.getElementById(id);
			var content = item.children[1];
			var textElement = content.children[1].getElementsByClassName("text");
			var sum = content.children[2];

			var text = textElement[0].textContent; // кол-во
			var name = item.children[0].textContent.replace(/ /g, '_');
			var price = content.children[0].textContent.slice(8); // цена

			var mainSum = document.getElementById("main-sum").textContent.slice(7);
			var mainCount = document.getElementById("main-count").textContent.slice(25);

			if (o == "-") {
				if (text > 0) {
					text--;
					sum.textContent = text * price;
					textElement[0].textContent = text;
					mainSum -= price;
					mainCount--;
					if (text == 0) {
						localStorage.removeItem("el-" + id);
						item.className = "item";
					} else {
						localStorage.setItem("el-" + id, text + "+" + name + "+" + price);
					}
				}
			} else {
				if (text != 10) {
					mainCount++;
					text++;
					sum.textContent = text * price;
					textElement[0].textContent = text;
					mainSum = Number.parseInt(mainSum) + Number.parseInt(price);
				}
				item.className = "selected item";
				localStorage.setItem("el-" + id, text + "+" + name + "+" + price);
			}
			document.getElementById("main-sum").textContent = "Сомма: " + mainSum;
			document.getElementById("main-count").textContent = "Таңдалған тауарлар саны: " + mainCount;
		}

		function onLoad(group) {
			var groupElement = document.getElementById(group);
			// var grid = groupElement.childNodes[2];
			var items = groupElement.childNodes;
			var mainSum = 0;
			var mainCount = 0;

			for (var i = 5; i < items.length; i+=2) {
				for (var j = 0; j < localStorage.length; j++) {
					var key = localStorage.key(j);
					if ("el-" + items[i].childNodes[1].id == key) {
						items[i].childNodes[1].className = "selected item";
						var value = localStorage.getItem(key);
						var text = items[i].getElementsByClassName("text")[0];
						text.textContent = value.slice(0, value.indexOf("+"));
						var sum = items[i].getElementsByClassName("sum")[0];
						var price = items[i].getElementsByClassName("price")[0].textContent.slice(8);
						sum.textContent = (value.slice(0, value.indexOf("+")) * price);
						mainSum += Number.parseInt(sum.textContent);
						mainCount += Number.parseInt(text.textContent);
					}
				}
			}
			return [mainSum, mainCount];
		}
	</script>
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="../js/bootstrap.min.js"></script>
</body>
</body>
</html>