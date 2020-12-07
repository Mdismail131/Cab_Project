$(document).ready(function(){
    $("#FormControlSelect3").on("change", function(){
        var cabtype = $("#FormControlSelect3").val();
        if (cabtype == "CedMicro") {
            $("#luggage").prop("disabled", true);
            $("#luggage").val(null);
        } else {
            $("#luggage").prop("disabled", false);
        }
        $("#res").css("display", "none");
        $("#book").css("display", "none");
        $("#result").html("");
    });
    $("#FormControlSelect1,#FormControlSelect2").on("change", function(){
        $("#res").css("display", "none");
        $("#book").css("display", "none");
        $("#result").html("");
    });
    $('.numbers').on('keyup', function () {
        this.value = this.value.replace(/[^0-9]/g,'');
    });
    $('.uname').on('keyup', function () {
        this.value = this.value.replace(/[^a-zA-Z0-9\_]/g, '');
    });
    $('.name').on('keyup', function () {
        this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
    });
    $('#luggage').on('focus', function () {
        $("#res").css("display", "none");
        $("#book").css("display", "none");
        $("#result").html("");
    });
    $("#calculate").on('click', function(){
        var currentloc= $("#FormControlSelect1").val();
        var droploc= $("#FormControlSelect2").val();
        var cabtype = $("#FormControlSelect3").val();
        var luggage = $("#luggage").val();
        if( currentloc == droploc) {
            alert("PickUp and Destination must be different");
        } else if (currentloc == "Current Location" || droploc == "Destination" || cabtype == "select cab type") {
            alert("Please Select the Valid Inputs");
        } else {
            $.ajax({
                method: 'POST',
                url: 'ajax.php',
                dataType: 'text',
                data: {
                    currentloc: currentloc,
                    droploc: droploc,
                    cabtype: cabtype,
                    luggage: luggage
                },
                success: function(response) {
                    $('#res').css('display', 'block');
                    $('#book').css('display', 'block');
                    $('#result').html(response);
                }
            })
        }
    });
});

