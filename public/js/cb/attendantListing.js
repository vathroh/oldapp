$(document).ready(function () {

	var activity_id = $("#activity_id").val();
	var role = $("#role").val();
	$.get('/ajax-listing-ready?&activity_id=' + activity_id + '&role=' + role, function (data) {
		console.log(data);
        $("#registered_users").empty();
        $.each(data[0], function (index, usersObj) {
			$("#registered_users").append('<option value="' + usersObj.user_id + '">' + (index+1) + '. ' + usersObj.name + ' | ' + usersObj.job_title + ' | ' + usersObj.NAMA_KAB + '</option>');
		});

		$("#users").empty();
        $.each(data[1], function (index, usersObj) {
			$("#users").append('<option value="' + usersObj.user_id + '">' + (index+1) + '. ' + usersObj.name + ' | ' + usersObj.job_title + ' | ' + usersObj.NAMA_KAB + '</option>');
		});
	});

	$("#role").change(function() {
	$(this).css('color', 'red');


		document.getElementById("find_district").innerHTML = "<option value=''>Cari berdasarkan kabupaten penugasan</option><option value='3307'>WONOSOBO</option><option value='3315'>GROBOGAN</option><option value='3316'>BLORA</option><option value='3317'>REMBANG</option><option value='3318'>PATI</option><option value='3319'>KUDUS</option><option value='3320'>JEPARA</option><option value='3321'>DEMAK</option><option value='3322'>SEMARANG</option><option value='3323'>TEMANGGUNG</option><option value='3324'>KENDAL</option><option value='3325'>BATANG</option><option value='3326'>PEKALONGAN</option><option value='3327'>PEMALANG</option><option value='3328'>TEGAL</option><option value='3329'>BREBES</option><option value='3373'>KOTA SALATIGA</option><option value='3374'>KOTA SEMARANG</option><option value='3375'>KOTA PEKALONGAN</option><option value='3376'>KOTA TEGAL</option>";


		$("#find_name").val('');
		var activity_id = $("#activity_id").val();
		var role = $("#role").val();

		$.get('/ajax-listing-ready?&activity_id=' + activity_id + '&role=' + role, function (data) {
			console.log(data);
			$("#registered_users").empty();
			$.each(data[0], function (index, usersObj) {
				$("#registered_users").append('<option value="' + usersObj.user_id + '">' + (index+1) + '. ' + usersObj.name + ' | ' + usersObj.job_title + ' | ' + usersObj.NAMA_KAB + '</option>');
			});



			$("#users").empty();
			$.each(data[1], function (index, usersObj) {
				$("#users").append('<option value="' + usersObj.user_id + '">' + (index+1) + '. ' + usersObj.name + ' | ' + usersObj.job_title + ' | ' + usersObj.NAMA_KAB + '</option>');
			});
		});
	});

    $("#find_district").change(function () {
		var role = $("#role").val();
        var kode_kabupaten = $("#find_district").val();
        document.getElementById("find_name").value = "";

        $.get('/ajax-listing-attendant?kode_kabupaten=' + kode_kabupaten + '&activity_id=' + activity_id + '&role=' + role, function (data) {
            console.log(data);
            $("#users").empty();
            $("#registered_users").empty();

            $.each(data[0], function (index, usersObj) {
                $("#registered_users").append('<option value="' + usersObj.user_id + '">' + (index+1) + '. ' + usersObj.name + ' | ' + usersObj.job_title + ' | ' + usersObj.NAMA_KAB + '</option>');
            });

            $.each(data[1], function (index, usersObj) {
                $("#users").append('<option value="' + usersObj.user_id + '">' + (index+1) + '. ' + usersObj.name + ' | ' + usersObj.job_title + ' | ' + usersObj.NAMA_KAB + '</option>');
            });
        });
    });

    $("#find_name").keyup(function () {
		var role = $("#role").val();
        var nama = $("#find_name").val();
		var activity_id = $("#activity_id").val();

		document.getElementById("find_district").innerHTML = "<option value=''>Cari berdasarkan kabupaten penugasan</option><option value='3307'>WONOSOBO</option><option value='3315'>GROBOGAN</option><option value='3316'>BLORA</option><option value='3317'>REMBANG</option><option value='3318'>PATI</option><option value='3319'>KUDUS</option><option value='3320'>JEPARA</option><option value='3321'>DEMAK</option><option value='3322'>SEMARANG</option><option value='3323'>TEMANGGUNG</option><option value='3324'>KENDAL</option><option value='3325'>BATANG</option><option value='3326'>PEKALONGAN</option><option value='3327'>PEMALANG</option><option value='3328'>TEGAL</option><option value='3329'>BREBES</option><option value='3373'>KOTA SALATIGA</option><option value='3374'>KOTA SEMARANG</option><option value='3375'>KOTA PEKALONGAN</option><option value='3376'>KOTA TEGAL</option>";

        $.get('/ajax-listing-attendant-find-name?nama=' + nama + '&kegiatanid=' + activity_id + '&role=' +  role, function (data) {
            console.log(data);
            $("#users").empty();
            $("#registered_users").empty();

            $.each(data[1], function (index, usersObj) {
                $("#users").append('<option value="' + usersObj.user_id + '">' + (index+1) + '. ' + usersObj.name + ' | ' + usersObj.job_title + ' | ' + usersObj.NAMA_KAB + '</option>');
            });

            $.each(data[0], function (index, usersObj) {
                $("#registered_users").append('<option value="' + usersObj.user_id + '">' + (index+1) + '. ' + usersObj.name + ' | ' + usersObj.job_title + ' | ' + usersObj.NAMA_KAB + '</option>');
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
				role			: role,
				_token			: token,
				userId			: userId,
				activity_id		: activity_id,
				kode_kabupaten	: kode_kabupaten,
				nama			: nama,
				count:userId.length,

			},
			success: function(data) {
				$("#registered_users").empty();
				$("#users").empty();

				$.each(data[0], function (index, regUsersObj) {
					$("#registered_users").append('<option value="' + regUsersObj.user_id + '">' + (index+1) + '. ' + regUsersObj.name + ' | ' + regUsersObj.job_title + ' | ' + regUsersObj.NAMA_KAB + '</option>');
				});

				$.each(data[1], function (index, regUsersObj) {
					$("#users").append('<option value="' + regUsersObj.user_id + '">' + (index+1) + '. ' + regUsersObj.name + ' | ' + regUsersObj.job_title + ' | ' + regUsersObj.NAMA_KAB + '</option>');
				});

			}
		});
	});

	$("#remove").click(function () {
		var kode_kabupaten = $("#find_district").val();
		var token = $("meta[name='csrf-token']").attr("content");
		var nama = $("#find_name").val();
        var regUserId = $("#registered_users").val();
		var userId = $("#users").val();
		var role = $("#role").val();

		$.ajax({
			url: '/ajax-listing-delete',
			type: 'delete',
			data:{
				role			: role,
				nama			: nama,
				_token			: token,
				kode_kabupaten	: kode_kabupaten,
				regUserId		: regUserId,
				activity_id		: activity_id,
				count			: regUserId.length
			},
			success: function(data) {
				$("#registered_users").empty();
				$("#users").empty();

				$.each(data[0], function (index, regUsersObj) {
					$("#registered_users").append('<option value="' + regUsersObj.user_id + '">' + (index+1) + '. ' + regUsersObj.name + ' | ' + regUsersObj.job_title + ' | ' + regUsersObj.NAMA_KAB + '</option>');
				});

				$.each(data[1], function (index, regUsersObj) {
					$("#users").append('<option value="' + regUsersObj.user_id + '">' + (index+1) + '. ' + regUsersObj.name + ' | ' + regUsersObj.job_title + ' | ' + regUsersObj.NAMA_KAB + '</option>');
				});
			}
		});
	});
});


