function copyToClipboard(text) {
    var inputc = document.body.appendChild(document.createElement("input"));
    inputc.value = window.location.href;
    inputc.focus();
    inputc.select();
    document.execCommand('copy');
    inputc.parentNode.removeChild(inputc);
    // alert("kopirano!");
}

function getPrice(){

	var list_36 = [1120, 1130, 1140, 1150, 1160, 1170, 1180, 1190, 1210, 1220, 1230];

	let zip = $("#plz-input").val();
	zip = parseInt(zip);
	let price = 33;

	if(list_36.includes(zip)){
		price = 36
	}

	$("#price").text("Price: "+price+"€");
	$("#price_in_hidden").val(price);
}

function reload() {
  location.reload();
}

function send_driver_income(driver_id, startDate, endDate){
	$.ajax({
		type:'post',
		data: {func: 'get_driver_income', driver_id: driver_id, start: startDate, end: endDate, email_it: 1},
		url:"ajax_functions.php",
		dataType: "json",
		success: function(response) {
			$('#dataText').append("<p>Geschickt!</p>");
			console.log(response);
		},
		error: function(response) {
			$('#dataText').append("<p>Fehler!</p>");
			console.log(response);
		}
	});
}

function send_client_receipt(client, startDate, endDate){
	if(confirm("Sind Sie sicher, dass sie Den Kunden eine E-mail schicken will?")){
		$.ajax({
			type:'post',
			data: {func: 'get_client_rides', client_name: $('#client-name').val(), start: startDate, end: endDate, email_it: 1},
			url:"ajax_functions.php",
			dataType: "json",
			success: function(response) {
				$('#dataText').append("<p>Geschickt!</p>");
				console.log(response);
			},
			error: function(response) {
				$('#dataText').append("<p>Fehler!</p>");
				console.log(response);
			}
		});
	}
}

$(document).ready(function(){
    $('#colorselector').on('change', function() {
      if ( this.value == 'red')
      {
        $("#divid").show();
      }
      else
      {
        $("#divid").hide();
      }
    });
});