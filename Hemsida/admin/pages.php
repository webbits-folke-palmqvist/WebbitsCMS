<?php
$Check->login();

$sub = @$_GET['sub'];

if(!$sub){
	?>
	<a class="btn" href="?page=Pages&sub=add">Lägg till en sida</a>
	<hr>
	<?php $Success->show(); ?>
	<table class="table table-hover">
		<tr>
			<td><strong>Namn</strong></td>
			<td style="width:1%;"><strong>Ändra</strong></td>
			<td style="width:11%;"><strong>Ta bort</strong></td>
		</tr>
		<?php
		$result = mysql_query("SELECT * FROM pages WHERE deleted = '0' ORDER BY name");

		while($row = mysql_fetch_array($result)){
			$name = $row['name'];
			$name = str_replace("-"," ", $name);
			?>
			<tr>
				<td><a target="_Blank" href="../?page=<?php echo $row['name']; ?>"><?php echo $name; ?></a></td>
				<td><a class="btn" href="?page=Pages&sub=edit&id=<?php echo $row['id']; ?>">Ändra</a></td>
				<?php
				if($row['id'] == 1 OR $row['id'] == 2 OR $row['id'] == 3){
				} else {
					?>
					<td><a class="btn" href="../process.php?action=pages&do=delete&id=<?php echo $row['id']; ?>">Ta bort</a></td>
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
			<form action="../process.php?action=pages&do=add" method="POST">
				<?php $Error->show(); ?>
				<input class="input-fill" type="text" name="name" placeholder="Namn"><br />
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
				<a class="btn btn-danger" href="?page=Pages">Avbryt</a> <input class="btn btn-success" type="submit" value="Lägg till sidan">
			</form>
		</div>
		<?php
	} elseif ($sub == "edit"){
		$id = secure($_GET['id']);
		
		if(!$id){
			header('location: ?page=Pages');
		} else {
			$result = mysql_query("SELECT * FROM pages WHERE deleted = '0' AND id = '$id' LIMIT 1");

			while($row = mysql_fetch_array($result)){
				?>
				<div class="pages-add">
					<form action="../process.php?action=pages&do=edit" method="POST">
						<?php $Error->show(); ?>
						<input class="input-fill" type="text" name="name" placeholder="Namn" value="<?php echo $row['name'] ?>"><br />
						<textarea name="content"><?php echo $row['content'] ?></textarea>
						<input type="hidden" name="id" id="id" value="<?php echo $row['id'] ?>">
						<script language="javascript" type="text/javascript" src="../assets/tiny_mce/tiny_mce.js"></script>
					    <script language="javascript" type="text/javascript">
					    tinyMCE.init({
					            theme : "advanced",
					            mode : "textareas",
					            theme_advanced_toolbar_location : "top"
					    });
					    </script>
					    <br>
						<a class="btn btn-danger" href="?page=Pages">Avbryt</a> <input class="btn btn-success" type="submit" value="Spara ändringar">
					</form>
				</div>
				<?php
			}
		}
	}
}
?>