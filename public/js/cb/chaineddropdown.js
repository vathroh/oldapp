$(document).ready(function () {
    $("#activity").change(function () {
        // console.log();
        // var kode_kab = e.target.value;
        var question_id = $("#activity").val();
        //ajax

        $.get('/dropdown-question?question_id=' + question_id, function (data) {
            console.log(data);
            $("#question").empty();
            $("#question").append('<option value="">Pertanyaan</option>');
            $.each(data, function (index, questionObj) {
                $("#question").append('<option value="' + questionObj.id + '">' + questionObj.question + '</option>');
            });
        });
    });
});
