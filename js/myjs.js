$(function() {

    /*AJAX for submitting comment, inserts comment into databse and updates page*/
    $("#commentsform").submit(function(event) {
      var values = $("#commentsform").serialize();
      var comment = $("#commentinput").val();
      $.ajax({

			dataType: "json",
			type: "POST",
      url: "/commenthandler.php",
      data: values,
      success: function(Result) {
				if(Result.error == true) {
					$('#commenterror').text(Result.message);
				} else {
          $('#commenttable tbody').prepend("<tr><td>" +
	             Result.name + "</td><td>" + Result.comment  + "</td></tr>");
        	$('#comment').val('');
				}
      },
        error: function(Result) {
        alert("Bad Comment");
        }
       });
                return false;
    });

  /*Vote Button functionality, updates database and updates page to reflect new votecount*/
	$(".vote, #votebut").click(function() {
		var cat = $(this).attr("data-action");
		$.ajax({
			dataType: "json",
			type: "POST",
			url: "/vote.php?cat=" + cat,
			success: function(Result) {
				if(Result.error == true) {
					$('#novotes').text(Result.message);
					$('#novotes').css("visibility", "visible");
          $("#uservotes").text(Result.votes);
					$('html, body').animate({
						scrollTop: $("#userinfo").offset().top
					}, 250);

				} else {
					$("#" + cat + "votes").text(function(i, t) {
						return Number(t) + 1;
					});

					$("#uservotes").text(Result.votes);

				}
			},
			error: function () {
				alert("not nice vote");
			}
		});
		return false;
	});


  /*Sorts table based on column header clicked*/
	$('#catlist th').click(function() {
		var table = $(this).parents('table').eq(0);
		var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()));
		this.asc = !this.asc;
		if (!this.asc){ rows = rows.reverse()};
		for (var i = 0; i < rows.length; i++){table.append(rows[i])};
	});

  /*comparer function for sort()*/
	function comparer(index) {
		return function(a, b) {
			var valA = getCellValue(a, index), valB = getCellValue(b, index);
			return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.localeCompare(valB);
		}

	};

  /*gets cell value*/
	function getCellValue(row, index){ return $(row).children('td').eq(index).html() };






});
