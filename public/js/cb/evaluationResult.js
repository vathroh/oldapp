$(document).ready(function () {
	
	
    $("#subject").change(function () {
        var subject = $("#subject").val();
        $.get('/ajax-evaluation-result?materi=' + subject, function (data) {
			
			console.log(data);
            $("#participants").empty();            
            $.each(data, function (index, participantsObj) {
                $("#participants").append('<tr><td>' + participantsObj.name + '<td>' + participantsObj.job_title + '</td>' + '<td>' + participantsObj.NAMA_KAB + '</td>' + '</td></tr>');
            });
			
			
            
            
        });
    });	  
});
