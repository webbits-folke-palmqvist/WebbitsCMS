<?php
$Check->login();

$sub = @$_GET['sub'];

if(!$sub){
	?>
	<a class="btn" href="?page=Members&sub=add">Skapa en användare</a>
	<hr>
	<?php
	$Success->show();
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
			<?php if($User->rank() == 9) { ?><td><a class="btn" href="../process.php?action=members&do=delete&id=<?php echo $row['id']; ?>">Ta bort</a></td><?php } ?>
			</tr>
			<?php
		}
		?>
	</table>
	<?php
} else {
	
}
?>