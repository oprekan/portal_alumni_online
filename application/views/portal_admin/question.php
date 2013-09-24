<style>
	.alignLeft {
		text-align: left; !important;
	}
	
	.flexigrid tr td.sorted {
		background: none repeat scroll 0 0 #F3F3F3;
		border-bottom: 1px solid #F3F3F3;
		border-right: 1px solid #DDDDDD;
		white-space: normal;
	}
</style>
<article class="module width_full">
	<table class="flexme3" style="display: none"></table>
	<script type="text/javascript">
	$(document).ready(function() {
		var varId = <?php echo $variable_id;?>;
		$(".flexme3").flexigrid({
			id : 'menu_grid',
			url : 'portal_admin/quesioners/get_question/'+varId,
			dataType : 'json',
			sortname : "pertanyaan",
			sortorder : "asc",
			usepager : true,
			title : 'Question List',
			useRp : true,
			rp : 15,
			showTableToggleBtn : true,
			width : '100%',
			height : 350,
			singleSelect: true,
			onSuccess : function () {
				
			},
			colModel : [ 
			{
				display : 'No',
				name : 'no',
				width : 20,
				sortable : false,
				align : 'center'
			},{
				display : 'ID Pertanyaan',
				name : 'id',
				width : 150,
				sortable : true,
				align : 'left',
				hide : true
			},{
				display : 'Pertanyaan',
				name : 'pertanyaan',
				width : 500,
				sortable : true,
				align : 'left'
			},{
				display : 'Tipe',
				name : 'tipe',
				width : 100,
				sortable : true,
				align : 'center'
			},{
				display : 'Edit',
				name : 'edit',
				width : 50,
				sortable : true,
				align : 'center',
				hide : false,
				process : procEdit
			}, {
				display : 'Delete',
				name : 'delete',
				width : 50,
				sortable : true,
				align : 'center',
				hide : false,
				process : procDelete
			}],
			buttons : [ {
				name : 'Add',
				bclass : 'add',
				onpress : addData
			},{
				separator : true
			} ],
			searchitems : [ {
				display : 'Pertanyaan',
				name : 'pertanyaan',
				isdefault : true
			},{
				display : 'Tipe',
				name : 'tipe'
			}]
		});
		
		// -- Func. Ajax Delete
		function ajaxDelete (id) {
			$(".alert_info").text("Deleting data...")
			$.ajax({
				type : 'POST'
				,url : 'portal_admin/quesioners/delete_question'
				,data : 'id='+id
				,success : function (resp) {
					var info = $(".alert_info");
					var error = $(".alert_error");
					var success = $(".alert_success");
					if (resp == "success") {
						if (info.length != 0) {
							$(".alert_info").replaceWith("<h4 class='alert_success'>Data has been deleted</h4>");
						} 
						else if (error.length != 0){
							$(".alert_error").replaceWith("<h4 class='alert_success'>Data has been deleted</h4>");
						} else if (success.length != 0) {
							$(".alert_success").replaceWith("<h4 class='alert_success'>Data has been deleted</h4>");
						}
						 $(".flexme3").flexReload();
					} else {
						if (info.length != 0) {
							$(".alert_info").replaceWith("<h4 class='alert_error'>"+resp+"</h4>");
						} 
						else if (error.length != 0){
							$(".alert_error").replaceWith("<h4 class='alert_error'>"+resp+"</h4>");
						} else if (success.length != 0) {
							$(".alert_success").replaceWith("<h4 class='alert_error'>"+resp+"</h4>");
						}
						return false;
					}
				}
			});
		}
		
		// -- Func. Cell Click for editing
		function procEdit(celDiv,id)
		{
			$(celDiv).click
			(
				function ()
				{
					window.location = "portal_admin/quesioners/update_question/"+varId+"/"+id;
				}
			);
		} 
		
		// -- Func. Cell Click for deleting
		function procDelete(celDiv,id)
		{
			$(celDiv).click
			(
				function ()
				{
					pertanyaan = $('.flexme3 tr#row'+id+' td:nth-child(2) div').text();
					var answer = confirm('Anda yakin akan menghapus pertanyaan ini ?');
					if (answer) {
						ajaxDelete(id);
					} else {
						return false;
					}
				}
			);
		} 
		
		function addData(com, grid) {
			if (com == 'Add') {
				window.location = "portal_admin/quesioners/add_question/"+varId;
			}
		}
	});
	</script>
</article>