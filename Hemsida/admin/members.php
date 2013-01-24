<?php
$Check->login();

$sub = @$_GET['sub'];

if(!$sub){
	?>
	<a class="btn" href="?page=Members&sub=add">Skapa en användare</a>
	<hr>
	<?php
	$Success->show();
	$Error->show();
	?>
	<table class="table table-hover">
		<tr>
			<td style="width:1px;"><strong>#</strong></td>
			<td><strong>Användarnamn</strong></td>
			<td style="width:1%;"><strong>Ändra</strong></td>
			<td style="width:11%;"><strong>Ta bort</strong></td>
		</tr>
		<?php
		if($User->rank() == 9){
			$result = mysql_query("SELECT * FROM users WHERE deleted = '0' ORDER BY username DESC");
		} else {
			$result = mysql_query("SELECT * FROM users WHERE deleted = '0' AND rank != '9' ORDER BY username DESC");
		}

		while($row = mysql_fetch_array($result)){
			?>
			<td><?php echo $row['id']; ?></td>
			<td><?php echo $row['username']; ?></td>
			<td><a class="btn" href="?page=Members&sub=edit&id=<?php echo $row['id']; ?>">Ändra</a></td>
			<?php
			if($User->rank() != 9) {
				?>
				<td><a class="btn" href="../process.php?action=members&do=delete&id=<?php echo $row['id']; ?>">Ta bort</a></td>
				<?php 
			}
			?>
			</tr>
			<?php
		}
		?>
	</table>
	<?php
} else {
	if($sub == "edit"){
		$id = $_GET['id'];
		$Error->show();
		$Success->show();

		$result = mysql_query("SELECT * FROM users WHERE id = '$id' LIMIT 1");

		$row = mysql_fetch_row($result);
		?>
		<form action="../process.php?action=users&do=edit&id=<?php echo $id; ?>" method="POST">
			<table class="center">
				<tr>
					<td><strong>Användarnamn:</strong></td>
					<td><input type="text" name="username" placeholder="Användarnamn" value="<?php echo $row[1] ?>"></td>
				</tr>
				<tr>
					<td><strong>Nytt lösenord:</strong></td>
					<td><input type="password" name="password" placeholder="Nytt lösenord"> - <i>ifall du ska byta lösenord på denna användaren, skriv det här.</i></td>
				</tr>
				<tr>
					<td><strong>Rank:</strong></td>
					<td>
						<select name="rank">
						  	<option value="0" <?php if($row[3] == 0){ echo "selected"; } ?>>Bannad</option>
						  	<option value="1" <?php if($row[3] == 1){ echo "selected"; } ?>>Medlem</option>
						  	<option value="9" <?php if($row[3] == 9){ echo "selected"; } ?>>Admin</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><input class="btn" type="submit" value="Spara"></td>
				</tr>
			</table>
		</form>
		<?php
	} elseif ($sub == "add") {
		$Error->show();
		?>
		<form action="../process.php?action=users&do=add&id=<?php echo $id; ?>" method="POST">
			<table class="center">
				<tr>
					<td><strong>Användarnamn:</strong></td>
					<td><input type="text" name="username" placeholder="Användarnamn"></td>
				</tr>
				<tr>
					<td><strong>Lösenord:</strong></td>
					<td><input type="password" name="password" placeholder="Lösenord"></td>
				</tr>
				<tr>
					<td><strong>Rank:</strong></td>
					<td>
						<select name="rank">
						  	<option value="0">Bannad</option>
						  	<option value="1" selected>Medlem</option>
						  	<option value="9">Admin</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><input class="btn" type="submit" value="Skapa användaren"></td>
				</tr>
			</table>
		</form>
		<?php
	}
}
?>