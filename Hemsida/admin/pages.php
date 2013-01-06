<table class="table table-hover">
	<tr>
		<td style="width:1px;"><strong>#</strong></td>
		<td><strong>Namn</strong></td>
		<td style="width:1%;"><strong>Ändra</strong></td>
		<td style="width:11%;"><strong>Ta bort</strong></td>
	</tr>
	<?php
	$result = mysql_query("SELECT * FROM pages WHERE deleted = '0', name != '404', name != 'contact'");

	while($row = mysql_fetch_array($result)){
		?>
		<tr>
		<td><?php echo $row['id']; ?></td>
		<td><a href="#"><?php echo $row['name']; ?></a></td>
		<td><a class="btn" href="#">Ändra</a></td>
		<?php
		if($row['name'] != "Hem" OR $row['name'] != "404"){
			?>
			<td><a class="btn" href="#">Ta bort</a></td>
			<?php
		}
		?>
		</tr>
		<?php
	}
	?>
</table>