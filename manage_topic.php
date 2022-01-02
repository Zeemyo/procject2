<?php 
include 'db_connect.php';
/* include 'photoadd.php'; */
?>



<?php
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM topics where id=".$_GET['id'])->fetch_array();
	foreach($qry as $k =>$v){
		$$k = $v;
	}
}

?>

<div class="container-fluid">
	<form action="" id="manage-topic">
				<input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id']:'' ?>" class="form-control" required>
		<div class="row form-group">
			<div class="col-md-8">
				<label class="control-label">Title</label>
				<input type="text" name="title" class="form-control" value="<?php echo isset($title) ? $title:'' ?>" required>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-8">
				<label class="control-label">Tags/Category</label>
				<select name="category_ids[]" id="category_ids" multiple="multiple" class="custom-select select2" required>
					<option value=""></option>
				<?php
				$tag = $conn->query("SELECT * FROM categories order by name asc");
				while($row= $tag->fetch_assoc()):
				?>
					<option value="<?php echo $row['id'] ?>" <?php echo isset($category_ids) && in_array($row['id'], explode(",",$category_ids)) ? "selected" : '' ?>><?php echo $row['name'] ?></option>
			<?php endwhile; ?>
			</select>
			</div>
		</div>

		
		<div class="row form-group">
			<div class="col-md-12">
				<label class="control-label">Content</label>
				<input name="picture" id="picture" class="form-control" type="file">
			</input>
				<textarea name="content" class="text-jqte" required>
					<?php echo isset($content) ? $content : ''?></textarea>
					
			</div>
		</div>
	</form>
</div>

<script>
	$('.select2').select2({
		placeholder:"Please select here",
		width:"100%"
	})
	$('.text-jqte').jqte();
	$('#manage-topic').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_topic',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp == 0){
					alert_toast("Berhasil membuat topic",'success') 
					setTimeout(function(){
						location.reload()
					},1000)
				} else {
					alert_toast("Gagal membuat topic",'warning')
					setTimeout(function(){
						location.reload()
					},1000)
				}
			}
		})
	})
</script>