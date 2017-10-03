(function($) {
	// fungsi dijalankan setelah seluruh dokumen ditampilkan
	$(document).ready(function(e) {
		
		$('.edit').live("click", function(){			
			var url = "vieworder.php";			
			idbrg = this.id;
			$.post(url, {id: idbrg} , function(data) {
				$("#vieworder").html(data).show();
			});
		});

		
	});

}) (jQuery);
