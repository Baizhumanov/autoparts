<?
	session_start();
	if (isset($_SESSION["login"])) {
		$sname = $_SESSION["surname"];
		$name = $_SESSION["name"];
		$login = $_SESSION["login"];
		$hide = true;
	}
	// echo "<pre>";
	// echo $_SESSION;
	// echo "</pre>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Autogo</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<header>
		<nav class="navbar navbar-expand-md navbar-toggleable navbar-dark">
			<a class="navbar-brand name" href="#">Автобөлшектер дүкені</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#items" aria-controls="items" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="items">
				<ul class="nav navbar-nav items ml-auto">
					<li class="nav-item"><a href="basket/">Себет</a></li>
					<li class="nav-item"><a href="access/">Аксессуарлар</a></li>
					<li class="nav-item <? if ($hide) echo "hide"; ?>">
						<a href="auth/?service=login">Кіру</a>
					</li>
					<li class="nav-item button <? if ($hide) echo "hide"; ?>">
						<a href="auth/?service=registration">Тіркелу</a>
					</li>
					<?if ($hide) { for ($i=0; $i < 1; $i++): ?>
						<li class="nav-item">
							<a href="user/?login=<? echo $login; ?>">
								Жеке бөлме
							</a>
						</li>
					<? endfor; } ?>
				</ul>
			</div>
		</nav>

		<div class="container">
			<div class="row justify-content-center my-5">
				<div class="col-12 col-sm-10 col-lg-8 brand-title text-center">Жеңіл көліктердің автобөлшектердің дүкені</div>
			</div>
			<div class="row justify-content-center mb-5">
				<div class="col-12 col-sm-10 col-lg-8 brand-def text-center">Бұл жерде сіз жеңіл көліктерге арналған автобөлшектерді таба аласыз. Тауарлардың арасында антифриз, қозғалтқышқа арналған май және аксессуарлар да бар!</div>
			</div>
		</div>
	</header>
	<main>
		<div class="container p-3">
			<div class="row text-center">
				<div class="col title">Көлік маркасын таңдаңыз</div>
			</div>
			<div class="row">
				<div class="col-12 col-sm-6 col-md-4 col-lg-3 nth" onclick="openPage('audi')">
					<div class="card">
						<div class="icon"></div>
						<div class="name">Audi</div>
					</div>
				</div>
				<div class="col-12 col-sm-6 col-md-4 col-lg-3 nth" onclick="openPage('mercedes')">
					<div class="card">
						<div class="icon"></div>
						<div class="name">Mercedes</div>
					</div>
				</div>
				<div class="col-12 col-sm-6 col-md-4 col-lg-3 nth" onclick="openPage('toyota')">
					<div class="card">
						<div class="icon"></div>
						<div class="name">Toyota</div>
					</div>
				</div>
				<div class="col-12 col-sm-6 col-md-4 col-lg-3 nth" onclick="openPage('hyundai')">
					<div class="card">
						<div class="icon"></div>
						<div class="name">Hyundai</div>
					</div>
				</div>
				<div class="col-12 col-sm-6 col-md-4 col-lg-3 nth" onclick="openPage('bmw')">
					<div class="card">
						<div class="icon"></div>
						<div class="name">BMW</div>
					</div>
				</div>
				<div class="col-12 col-sm-6 col-md-4 col-lg-3 nth" onclick="openPage('honda')">
					<div class="card">
						<div class="icon"></div>
						<div class="name">Honda</div>
					</div>
				</div>
				<div class="col-12 col-sm-6 col-md-4 col-lg-3 nth" onclick="openPage('vw')">
					<div class="card">
						<div class="icon"></div>
						<div class="name">VW</div>
					</div>
				</div>
				<div class="col-12 col-sm-6 col-md-4 col-lg-3 nth" onclick="openPage('lexus')">
					<div class="card">
						<div class="icon"></div>
						<div class="name">Lexus</div>	
					</div>
				</div>
				<div class="col-12 col-sm-6 col-md-4 col-lg-3 nth" onclick="openPage('mazda')">
					<div class="card">
						<div class="icon"></div>
						<div class="name">Mazda</div>
					</div>
				</div>
				<div class="col-12 col-sm-6 col-md-4 col-lg-3 nth" onclick="openPage('mitsubishi')">
					<div class="card">
						<div class="icon"></div>
						<div class="name">Mitsubishi</div>
					</div>
				</div>
				<div class="col-12 col-sm-6 col-md-4 col-lg-3 nth" onclick="openPage('chevrolet')">
					<div class="card">
						<div class="icon"></div>
						<div class="name">Chevrolet</div>
					</div>
				</div>
				<div class="col-12 col-sm-6 col-md-4 col-lg-3 nth" onclick="openPage('ford')">
					<div class="card">
						<div class="icon"></div>
						<div class="name">Ford</div>
					</div>
				</div>
			</div>
		</div><!-- style="background-color: #343334;" -->
		<div class="container-fluid bgadd">
			<div class="row justify-content-around py-5">
				<div class="col-10 col-md-5 my-4">
					<div class="platform">
						<div class="title">Қозғалтқышқа арналған май каталогі</div>
						<div class="def">Қозғалтқышқа арналған майды осы жерде таба аласыз. Оларды көлем және тип бойынша жіктей аласыз</div>
						<a href="oil/" class="btn btn-primary btn-lg mt-4 btn-block">Каталогты ашу</a>
					</div>
				</div>
				<div class="col-10 col-md-5 my-4">
					<div class="platform">
						<div class="title">Антифриз каталогі</div>
						<div class="def">Антифризді келесі каталогте таба аласыз. Оларды көлем және тип бойынша жіктей аласыз <br></div>
						<a href="antifreeze/" class="btn btn-primary btn-lg mt-4 btn-block">Каталогты ашу</a>
					</div>
				</div>
			</div>
		</div>
	</main>
	<footer class="py-5">
		<div class="container">
			<div class="row justify-content-between">
				<div class="col-12 col-sm-5">
					<div class="name">Автобөлшектер дүкені</div>
				</div>
				<div class="col-12 col-sm-5">
					<div class="add">
						Нұр-Сұлтан қаласы <br>
						Ш. Құдайбердіұлы 34 <br>
						+7 (7172) 726-172 <br>
						+7 (7172) 726-182 <br>
					</div>
				</div>
			</div>
		</div>
	</footer>

	<script>
		function openPage(car) {
			location.assign("group-part/?name=" + car);
		}
	</script>
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>