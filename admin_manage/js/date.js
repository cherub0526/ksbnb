$(document).ready(function(){
	$('#f_month').change(function(){
		var year = $(this).prevAll('#f_year').val();
		var month = $(this).val();
		$.ajax({
			type : "POST",
			url : "date.php",
			data : 
			{
				year : year,
				month : month
			},
			error: function(data){
				alert("AJAX 傳送失敗!");
			},
			success: function(data){
				$('#f_day').html(data)
			}
		});
	});
	$('#s_month').change(function(){
		var year = $(this).prevAll('#s_year').val();
		var month = $(this).val();
		$.ajax({
			type : "POST",
			url : "date.php",
			data : 
			{
				year : year,
				month : month
			},
			error: function(data){
				alert("AJAX 傳送失敗!");
			},
			success: function(data){
				$('#s_day').html(data)
			}
		});
	});
	$('#t_month').change(function(){
		var year = $(this).prevAll('#t_year').val();
		var month = $(this).val();
		$.ajax({
			type : "POST",
			url : "date.php",
			data : 
			{
				year : year,
				month : month
			},
			error: function(data){
				alert("AJAX 傳送失敗!");
			},
			success: function(data){
				$('#t_day').html(data)
			}
		});
	});
	
	$('#f_year').change(function(){
		var month = $(this).nextAll('#f_month').val();
		var year = $(this).val();
		if(month != "")
		{
			$.ajax({
				type : "POST",
				url : "date.php",
				data : 
				{
					year : year,
					month : month
				},
				error: function(data){
					alert("AJAX 傳送失敗!");
				},
				success: function(data){
					$('#f_day').html(data)
				}
			});
		}
	});
	
	$('#s_year').change(function(){
		var month = $(this).nextAll('#s_month').val();
		var year = $(this).val();
		if(month != "")
		{
			$.ajax({
				type : "POST",
				url : "date.php",
				data : 
				{
					year : year,
					month : month
				},
				error: function(data){
					alert("AJAX 傳送失敗!");
				},
				success: function(data){
					$('#s_day').html(data)
				}
			});
		}
	});
	
	$('#t_year').change(function(){
		var month = $(this).nextAll('#t_month').val();
		var year = $(this).val();
		if(month != "")
		{
			$.ajax({
				type : "POST",
				url : "date.php",
				data : 
				{
					year : year,
					month : month
				},
				error: function(data){
					alert("AJAX 傳送失敗!");
				},
				success: function(data){
					$('#t_day').html(data)
				}
			});
		}
	});
})