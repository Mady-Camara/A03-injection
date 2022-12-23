<?php
include 'conn.php';
include 'session.php';
$userID = $_SESSION['userID'];
if(isset($_POST['add'])){
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$insert = "insert into info_tbl (firstName,lastName,custid) values ('$fname','$lname','$userID')";
	if($conn->query($insert)== TRUE){
			echo "Insertion reussie";
			header('location:maintenance.php?id='.$userID);
	}else{
		echo "Ooppss cannot add data" . $conn->connect_error;
		header('location:maintenance.php?id='.$userID);
	}
	$insert->close();
}
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="mycss.css">
		<title>
			Accueil
		</title>
		</head>
	<body>
		<div id="body">
			<div id="menu">
			<ul>
				<li><a href="home.php">Accueil</a></li>
				<li><a href="maintenance.php?id=<?php echo $userID ?>">Maintenance</a></li>
				<li><a href="logout.php">Se deconnecter</a></li>
			</ul>
			</div>
			<div id="content">
				<form action="result.php" method="get" ecntype="multipart/data-form">
						<table align="center">
							<tr>
								<td>Faire une recherche : <input type="text" name="query"><input type="submit" value="Rechercher" name="search"></td>
							</tr>
						</table>
				</form>
				<form action="maintenance.php" method="POST">
				<table align="center">
					<tr>
						<td>Prenom : <input type="text" name="fname" value="" placeholder="Entrer votre prenom ici..." required></td>
						</tr>
						<tr>
							<td>Nom : <input type="text" name="lname" placeholder="Entrer votre prenom ici.." required></td>
						</tr>
						<tr>
							<td><input type="submit" name="add" value="Ajouter"></td>
						</tr>
				</table>
			</form>
				<br>
				<table align="center" border="1" cellspacing="0" width="500">
					<tr>
					<th>Prenom</th>
					<th>Nom</th>
					<th>Actions</th>
					</tr>
					<?php
					if(isset($_GET['id'])){
						$uid =$_GET['id'];
						$sql = "SELECT * FROM info_tbl WHERE custid=".$uid;
						$result = $conn->query($sql);
						if($result->num_rows > 0){
						while($row = $result->fetch_array()){
							?>
							<tr>
								<td align="center"><?php echo $row['firstName'];?></td>
								<td align="center"><?php echo $row['lastName'];?></td>
								<td align="center"><a href="edit.php?infoID=<?php echo md5($row['infoID']);?>">Modifier
								</a>/<a href="delete.php?infoID=<?php echo md5($row['infoID']);?>">Supprimer</a></td>
							</tr>
							<?php
						}
						}else{
								echo "<center><p> Pas d'enregistrement</p></center>";
						}
					}else{
						echo "<center><p> Pas d'enregistrement</p></center>";
					}
				$conn->close();
				?>
				</table>
			</div>
		</div>
		</body>

</html>