$(document).ready(function () {
  $("#search_btn").click(function () {
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
