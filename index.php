<?php

require_once 'vendor/autoload.php';

use CD\Container\CD;
use Demo\Controller\UserController;
use Demo\Repositories\LeadRepository;
use Demo\Repositories\TagRepository;
use Demo\Repositories\UserRepository;

//echo "Aqui será orquestrada a demonstração do Container de Dependências.";

$oContainer = new CD();
$oContainer->set('lead', function ($oContainer) {
	return new LeadRepository();
});

$oContainer->set('tag', function ($oContainer) {
	return new TagRepository();
});

$oContainer->set('user', function ($oContainer) {
	return new UserRepository();
});

$oContainer->singleton('user_controller', function (CD $oContainer) {
	return new UserController(
		$oContainer->get('tag'),
		$oContainer->get('user'),
		$oContainer->get('lead')
	);
});

$oUserController = $oContainer->get('user_controller');
$oUserController->iNumber = 1;

$oUserController2 = $oContainer->get('user_controller');

?>

<!doctype html>
<html lang="pt-BR">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Container de Dependências em PHP</title>
	<style>
		html {
			background-color: #ddd;
		}

		body {
			display: flex;
			justify-content: center;
			flex-direction: column;
			margin: 20px auto;
			background-color: white;
			box-shadow: 1px 1px 3px 3px gray;
			width: 900px;
			height: auto;
			padding: 20px;
		}

		table {
			width: 100%;
			text-align: center;
		}

		table caption {
			width: fit-content;
			font-size: 8pt;
		}

		table,
		td,
		th {
			border: 1px solid;
		}
	</style>
</head>

<body>
	<table>
		<caption>
			<h1>Demonstração do container de dependências</h1>
		</caption>
		<thead>
			<tr>
				<th colspan="4">
					Demonstração de singleton
				</th>
			</tr>
			<tr>
				<th>
					Nome
				</th>
				<th>
					Número
				</th>
				<th>
					Propriedade
				</th>
				<th>
					Valor
				</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					oUserController
				</td>
				<td>
					1
				</td>
				<td>
					iNumber
				</td>
				<td>
					<?= $oUserController->iNumber ?>
				</td>
			</tr>
			<tr>
				<td>
					oUserController2
				</td>
				<td>
					2
				</td>
				<td>
					iNumber
				</td>
				<td>
					<?= $oUserController2->iNumber ?>
				</td>
			</tr>
			<tr>
				<th colspan="4">
					Alterando a propriedade do oUserController2
					<pre style="margin: 0">
						<code>
$oUserController2->iNumber = 2 
<?php $oUserController2->iNumber = 2 ?>
						</code>
					</pre>
				</th>
			</tr>
			<tr>
				<td>
					oUserController
				</td>
				<td>
					1
				</td>
				<td>
					iNumber
				</td>
				<td>
					<?= $oUserController->iNumber ?>
				</td>
			</tr>
			<tr>
				<td>
					oUserController2
				</td>
				<td>
					2
				</td>
				<td>
					iNumber
				</td>
				<td>
					<?= $oUserController2->iNumber ?>
				</td>
			</tr>
		</tbody>
	</table>
	<table style="text-align: left;">
		<caption>
			<h1>Dependências salvas</h1>
		</caption>
		<thead>
			<tr>
				<td>
					<pre>
						<code>
<?php $oUserController->index() ?>
						</code>
					</pre>
					
				</td>
			</tr>
		</thead>
</body>

</html>