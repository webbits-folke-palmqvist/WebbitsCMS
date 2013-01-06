<?php
$sub = @$_GET['sub'];

if(!$sub){
	?>
	<a class="btn" href="?page=Pages&sub=add">Lägg till en sida</a>
	<hr>
	<table class="table table-hover">
		<tr>
			<td style="width:1px;"><strong>#</strong></td>
			<td><strong>Namn</strong></td>
			<td style="width:1%;"><strong>Ändra</strong></td>
			<td style="width:11%;"><strong>Ta bort</strong></td>
		</tr>
		<?php
		$result = mysql_query("SELECT * FROM pages WHERE deleted = '0', name != '404', name != 'contact' ORDER BY name");

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
	<?php
} else {
	if($sub == "add"){
		?>
		<div class="pages-add">
			<form action="../process.php&action=pages&do=add" method="POST">
				<input class="input-fill" type="text" name="title" placeholder="Titel"><br />
				<textarea name="content"></textarea>
				<script language="javascript" type="text/javascript" src="../assets/tiny_mce/tiny_mce.js"></script>
			    <script language="javascript" type="text/javascript">
			    tinyMCE.init({
			            theme : "advanced",
			            mode : "textareas",
			            theme_advanced_toolbar_location : "top"
			    });
			    </script>
			    <br>
			    <?php success(); ?>
				<a class="btn btn-danger" href="?page=Kategori&action=view&cat_id=<?php echo secure($_GET['cat_id']); ?>">Avbryt</a> <input class="btn btn-success" type="submit" value="Spara">
			</form>
		</div>
		<?php
	}
}
?>