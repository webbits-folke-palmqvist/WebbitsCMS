<?php
$Check->login();

$sub = @$_GET['sub'];

if(!$sub){
	$Error->show();
	$Success->show();
	?>
	<table class="table table-hover">
		<tr>
			<td style="width:1px;"><strong>Status</strong></td>
			<td><strong>Namn</strong></td>
			<td><strong>Email</strong></td>
			<td style="width:1px;"><strong>Läs</strong></td>
			<td style="width:11%;"><strong>Ta bort</strong></td>
		</tr>
		<?php
		$result = mysql_query("SELECT * FROM message WHERE deleted = '0' ORDER BY id DESC");

		while($row = mysql_fetch_array($result)){
			if($row['viewed'] == 0){
				?>
				<td><strong>Nytt!</strong></td>
				<?php
			} else {
				?>
				<td>Läst</td>
				<?php
			}
			?>
			<td><?php echo $row['from_name']; ?></td>
			<td><?php echo $row['from_email']; ?></td>
			<td><a class="btn" href="?page=Message&sub=Read&id=<?php echo $row['id']; ?>">Läs</a></td>
			<td><a class="btn" href="../process.php?action=message&do=delete&id=<?php echo $row['id']; ?>">Ta bort</a></td>
			</tr>
			<?php
		}
		?>
	</table>
	<?php
} else {
	if($sub == "Read"){
		$id = secure($_GET['id']);

		$sql = "UPDATE message SET viewed = 1 WHERE id = '$id' LIMIT 1";
		$update = mysql_query($sql);

		$result = mysql_query("SELECT * FROM message WHERE id = '$id' AND deleted = '0' LIMIT 1");
		$row = mysql_fetch_row($result);
		?>
		<strong>Ifrån:</strong> <?php echo $row[1]; ?>
		<br>
		<strong>Email:</strong> <?php echo $row[2]; ?>
		<br>
		<strong>Datum:</strong> <?php echo $Datentime->then($row[4]); ?>
		<hr>
		<?php echo $row[3]; ?>
		<?php
	}
}
?>