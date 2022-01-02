<?php include('db_connect.php');?>

<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row">
			<!-- FORM Panel -->
			<div class="col-md-4">
			<form action="" id="manage-filter">
				<div class="card">
					<div class="card-header">
						    Masukkan Kata yang ingin dilarang
				  	</div>
					<div class="card-body">
							<input type="hidden" name="id">
							<div class="form-group">
								<input type="text" class="form-control" name="name" required>
							</div>
					</div>
							
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12">
								<button class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Save</button>
								<button class="btn btn-sm btn-default col-sm-3" type="button" onclick="$('#manage-filter').get(0).reset()"> Cancel</button>
							</div>
						</div>
					</div>
				</div>
			</form>
			</div>
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">
						<b>Banned Word List</b>
					</div>
					<div class="card-body">
						<table class="table table-bordered table-hover">
							<colgroup>
								<col width="5%">
								<col width="75%">
								<col width="20%">
							</colgroup>
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Information</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$list = $conn->query("SELECT * FROM filters order by filter asc");
								while($row=$list->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="">
										<p>Dilarang: <b><?php echo $row['filter'] ?></b></p>
									</td>
									<td class="text-center">
										<!-- <button class="btn btn-sm btn-primary edit_name" type="button" data-id="<?php echo $row['id'] ?>" data-name="<?php echo $row['filter'] ?>">Edit</button> -->
										<button class="btn btn-sm btn-danger delete_filter" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
									</td>
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>	

</div>

<style>
	
	td{
		vertical-align: middle !important;
	}
</style>

<script>
	
	$('#manage-filter').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_filter',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully added",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}
				else if(resp==2){
					alert_toast("Data successfully updated",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}
			}
		})
	})
	

	$('.edit_name').click(function(){
		start_load()
		var cat = $('#manage-filter')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='filter']").val($(this).attr('data-name'))

		end_load()
	})
	$('.delete_filter').click(function(){
		_conf("Are you sure to delete this filter?","delete_filter",[$(this).attr('data-id')])
	})

	function delete_filter($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_filter',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
	$('table').dataTable()
</script>