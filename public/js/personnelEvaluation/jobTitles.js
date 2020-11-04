$(document).ready(function () {
	var quarter = $("#quarter").val();
        var year = $("#year").val();

        $.get('/personnnel-evaluation-getJobTitles?kuartal=' + quarter + '&&tahun=' + year, function (data) {
            console.log(data);
            $("tbody#belumDibuat").empty();
            $("tbody#belumSiap").empty();
            $("tbody#siap").empty();
            
            $.each(data[0], function (index, jobTitlesObj) {
                $("tbody#belumDibuat").append('<tr><td>' + (index+1) + '</td><td> Kuartal ' + data[1][0] +  ' Tahun ' + data[1][1] +'</td><td>' + jobTitlesObj.job_title + '</td><td class="text-center"><a href="/personnel-evaluation-setup/' + quarter + '/'  + year + '/' + jobTitlesObj.id + '"><button class ="btn btn-warning"><i class="material-icons">rule</i>Buat sekarang</button></a></td></tr>');
            });
            
             $.each(data[2], function (index, jobTitlesObj) {
                $("tbody#belumSiap").append('<tr><td>' + (index+1) + '</td><td> Kuartal ' + data[1][0] +  ' Tahun ' + data[1][1] +'</td><td>' + jobTitlesObj.job_title + '</td><td class="text-center"><a href="/personnel-evaluation-setup/' + jobTitlesObj.id + '/edit"><button class ="btn btn-primary"><i class="material-icons">rule</i>edit</button></a></td></tr>');
            });
            
            $.each(data[3], function (index, jobTitlesObj) {
               $("tbody#siap").append('<tr><td>' + (index+1) + '</td><td> Kuartal ' + data[1][0] +  ' Tahun ' + data[1][1] +'</td><td>' + jobTitlesObj.job_title + '</td><td class="text-center"><a href="/personnel-evaluation-setup/' + jobTitlesObj.id + '/edit"><button class ="btn btn-success"><i class="material-icons">rule</i>lihat</button></a></td></tr>');
            });   
            
        });
	
    $("select#quarter").change(function () {
        var quarter = $("#quarter").val();
        var year = $("#year").val();

        $.get('/personnnel-evaluation-getJobTitles?kuartal=' + quarter + '&&tahun=' + year, function (data) {
            console.log(data);
            $("tbody#belumDibuat").empty();
            $("tbody#belumSiap").empty();
            $("tbody#siap").empty();
            
            $.each(data[0], function (index, jobTitlesObj) {
                $("tbody#belumDibuat").append('<tr><td>' + (index+1) + '</td><td> Kuartal ' + data[1][0] +  ' Tahun ' + data[1][1] +'</td><td>' + jobTitlesObj.job_title + '</td><td class="text-center"><a href="/personnel-evaluation-setup/' + quarter + '/'  + year + '/' + jobTitlesObj.id + '"><button class ="btn btn-warning"><i class="material-icons">rule</i>Buat sekarang</button></a></td></tr>');
            });
            
             $.each(data[2], function (index, jobTitlesObj) {
                $("tbody#belumSiap").append('<tr><td>' + (index+1) + '</td><td> Kuartal ' + data[1][0] +  ' Tahun ' + data[1][1] +'</td><td>' + jobTitlesObj.job_title + '</td><td class="text-center"><a href="/personnel-evaluation-setup/' + jobTitlesObj.id + '/edit"><button class ="btn btn-primary"><i class="material-icons">rule</i>edit</button></a></td></tr>');
            });
            
            $.each(data[3], function (index, jobTitlesObj) {
               $("tbody#siap").append('<tr><td>' + (index+1) + '</td><td> Kuartal ' + data[1][0] +  ' Tahun ' + data[1][1] +'</td><td>' + jobTitlesObj.job_title + '</td><td class="text-center"><a href="/personnel-evaluation-setup/' + jobTitlesObj.id + '/edit"><button class ="btn btn-success"><i class="material-icons">rule</i>lihat</button></a></td></tr>');
            });    
        });
    });
    
    $("select#year").change(function () {
        var quarter = $("#quarter").val();
        var year = $("#year").val();

        $.get('/personnnel-evaluation-getJobTitles?kuartal=' + quarter + '&&tahun=' + year, function (data) {
            console.log(data);
            $("tbody#belumDibuat").empty();
            $("tbody#belumSiap").empty();
            $("tbody#siap").empty();
            
            $.each(data[0], function (index, jobTitlesObj) {
                $("tbody#belumDibuat").append('<tr><td>' + (index+1) + '</td><td> Kuartal ' + data[1][0] +  ' Tahun ' + data[1][1] +'</td><td>' + jobTitlesObj.job_title + '</td><td class="text-center"><a href="/personnel-evaluation-setup/' + quarter + '/'  + year + '/' + jobTitlesObj.id + '"><button class ="btn btn-warning"><i class="material-icons">rule</i>Buat sekarang</button></a></td></tr>');
            });
            
             $.each(data[2], function (index, jobTitlesObj) {
                $("tbody#belumSiap").append('<tr><td>' + (index+1) + '</td><td> Kuartal ' + data[1][0] +  ' Tahun ' + data[1][1] +'</td><td>' + jobTitlesObj.job_title + '</td><td class="text-center"><a href="/personnel-evaluation-setup/' + jobTitlesObj.id + '/edit"><button class ="btn btn-primary"><i class="material-icons">rule</i>edit</button></a></td></tr>');
            });
            
            $.each(data[3], function (index, jobTitlesObj) {
               $("tbody#siap").append('<tr><td>' + (index+1) + '</td><td> Kuartal ' + data[1][0] +  ' Tahun ' + data[1][1] +'</td><td>' + jobTitlesObj.job_title + '</td><td class="text-center"><a href="/personnel-evaluation-setup/' + jobTitlesObj.id + '/edit"><button class ="btn btn-success"><i class="material-icons">rule</i>lihat</button></a></td></tr>');
            });   
            
        });
    });
    
    

});


 
