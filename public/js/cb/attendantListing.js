$(document).ready(function () {
	
	var activity_id = $("#activity_id").val();
	$.get('/ajax-listing-ready?&activity_id=' + activity_id, function (data) {
		console.log(data);
        $("#registered_users").empty();
        $.each(data, function (index, usersObj) {
			$("#registered_users").append('<option value="' + usersObj.user_id + '">' + usersObj.name + ' | ' + usersObj.job_title + ' | ' + usersObj.NAMA_KAB + '</option>');
		});
	});
	
    $("#find_district").change(function () {
        var kode_kabupaten = $("#find_district").val();

        $.get('/ajax-listing-attendant?kode_kabupaten=' + kode_kabupaten, function (data) {
            console.log(data);
            $("#users").empty();
            document.getElementById("find_name").value = "";
            $.each(data, function (index, usersObj) {
                $("#users").append('<option value="' + usersObj.user_id + '">' + usersObj.name + ' | ' + usersObj.job_title + ' | ' + usersObj.NAMA_KAB + '</option>');
            });
        });
    });
    
    $("#find_name").keyup(function () {
        var nama = $("#find_name").val();

        $.get('/ajax-listing-attendant-find-name?nama=' + nama, function (data) {
            console.log(data);
            $("#users").empty();
            $.each(data, function (index, usersObj) {
                $("#users").append('<option value="' + usersObj.user_id + '">' + usersObj.name + ' | ' + usersObj.job_title + ' | ' + usersObj.NAMA_KAB + '</option>');
                document.getElementById("find_district").innerHTML = "<option value=''>Cari berdasarkan kabupaten penugasan</option><option value='3307'>WONOSOBO</option><option value='3315'>GROBOGAN</option><option value='3316'>BLORA</option><option value='3317'>REMBANG</option><option value='3318'>PATI</option><option value='3319'>KUDUS</option><option value='3320'>JEPARA</option><option value='3321'>DEMAK</option><option value='3322'>SEMARANG</option><option value='3323'>TEMANGGUNG</option><option value='3324'>KENDAL</option><option value='3325'>BATANG</option><option value='3326'>PEKALONGAN</option><option value='3327'>PEMALANG</option><option value='3328'>TEGAL</option><option value='3329'>BREBES</option><option value='3373'>KOTA SALATIGA</option><option value='3374'>KOTA SEMARANG</option><option value='3375'>KOTA PEKALONGAN</option><option value='3376'>KOTA TEGAL</option>";
            });
        });
    });    
    
    $("#register").click(function () {
		var token = $("meta[name='csrf-token']").attr("content");
		var kode_kabupaten = $("#find_district").val();		
		var activity_id = $("#activity_id").val();
		var nama = $("#find_name").val();
        var userId = $("#users").val();
		var role = $("#role").val();		
		
		$.ajax({
			url: '/ajax-listing-register',
			type: 'post',
			data:{
				_token:token,
				userId:userId,
				activity_id:activity_id,
				count:userId.length,
				role:role,
			},
			success: function(data) {
				$("#registered_users").empty();
				$.each(data, function (index, regUsersObj) {
				$("#registered_users").append('<option value="' + regUsersObj.user_id + '">' + regUsersObj.name + ' | ' + regUsersObj.job_title + ' | ' + regUsersObj.NAMA_KAB + '</option>');
				});
								
				$.get('/ajax-listing-moveReg?activity_id=' + activity_id + '&kode_kabupaten=' + kode_kabupaten + '&nama=' + nama, function (data) {
					console.log(data);
					$("#users").empty();
					$.each(data, function (index, usersObj) {
						$("#users").append('<option value="' + usersObj.user_id + '">' + usersObj.name + ' | ' + usersObj.job_title + ' | ' + usersObj.NAMA_KAB + '</option>');
						
					});
				});
			}			
		});		
	});
	
	$("#remove").click(function () {
		var kode_kabupaten = $("#find_registered_district").val();
		var unreg_kode_kabupaten = $("#find_district").val();
		var token = $("meta[name='csrf-token']").attr("content");
		var unreg_nama = $("#find_name").val();
		var nama = $("#find_registered_name").val();
        var regUserId = $("#registered_users").val();
		var userId = $("#users").val();
		
		$.ajax({
			url: '/ajax-listing-delete',
			type: 'delete',
			data:{
				_token:token,
				regUserId:regUserId,
				activity_id:activity_id,
				count:regUserId.length
			},
			success: function(data) {
				$("#registered_users").empty();
				$.each(data, function (index, regUsersObj) {
				$("#registered_users").append('<option value="' + regUsersObj.user_id + '">' + regUsersObj.name + ' | ' + regUsersObj.job_title + ' | ' + regUsersObj.NAMA_KAB + '</option>');
				});
				
				$.get('/ajax-listing-moveReg?activity_id=' + activity_id + '&kode_kabupaten=' + unreg_kode_kabupaten + '&nama=' + unreg_nama, function (data) {
				console.log(data);
				$("#users").empty();
				$.each(data, function (index, usersObj) {
					$("#users").append('<option value="' + usersObj.user_id + '">' + usersObj.name + ' | ' + usersObj.job_title + ' | ' + usersObj.NAMA_KAB + '</option>');
				});
            });
			}
		});		
	});    
});
