$(document).ready(function () {

  $( "#select_partenza" ).change(function() {
    $.ajax({
      type: "POST",
      url: "../../shared/provincia_search.php",
      data: {
        provincia: $("#select_partenza").val(),
      },
    }).done(function (data) {
      $("#citta_partenza").html(data);
    });
  });

  $( "#select_arrivo" ).change(function() {
    $.ajax({
      type: "POST",
      url: "../../shared/provincia_search.php",
      data: {
        provincia: $("#select_partenza").val(),
      },
    }).done(function (data) {
      $("#citta_arrivo").html(data);
    });
  });

  $("#search_btn").click(function () {
    if (!$("#search").hasClass("col-lg-6 col-md-12 col-sm-12")) {
      $("#search").addClass("col-lg-6 col-md-12 col-sm-12");
    }
    $("#results").removeClass('d-none');

    $.ajax({
      type: "POST",
      url: "client/search/search.php",
      data: {
        start_city: $("#inputStart").val(),
        destination_city: $("#inputDestination").val(),
        date: $("#inputDate").val(),
      },
    }).done(function (data) {
      $("#results").html(data);
    });
  });
});
