$(document).ready(function () {

	var $editing = false;

    $('.unplayed.new').click(function () {
    
    	if($editing == true){
    		
    		editToggle();
    	
    	};
    
        $('form#addUnplayed').slideToggle('slow', function () {
            // Animation complete.
        });
    });

    $('.unbeaten.new').click(function () {
        $('form#addUnbeaten').slideToggle('slow', function () {
            // Animation complete.
        });
    });

    $('.beaten.new').click(function () {
        $('form#addBeaten').slideToggle('slow', function () {
            // Animation complete.
        });
    });

    $('.abandoned.new').click(function () {
        $('form#addAbandoned').slideToggle('slow', function () {
            // Animation complete.
        });
    });

    $('#addUnplayed').submit(function (event) {

        event.preventDefault();

        $.post("api.php", {
            action: 'add',
            category: 'unplayed',
            name: $('#addUnplayed input[name="name"]').val(),
            platform: $('#addUnplayed input[name="platform"]').val(),
            note: $('#addUnplayed textarea').val()
        }, function (data) {
            if (data == "success") {

                $('#unplayed').append(" <li title=\"" + $('#addUnplayed input[name="name"]').val() + "\">" + $('#addUnplayed input[name="name"]').val() + " <a href=\"#\"><span class='deleteButton'>&#x2716;</span></a> <span>" + $('#addUnplayed input[name="platform"]').val() + "</span><span>" + $('#addUnplayed textarea').val() + "</span></li>");

                $(':input', '#addUnplayed').not(':button, :submit, :reset, :hidden').val('').removeAttr('checked').removeAttr('selected');
                //hideForm();


            } else {
                alert(data);
            };
            //alert(data);
        });
    });

    $('#addAbandoned').submit(function (event) {

        event.preventDefault();

        $.post("api.php", {
            action: 'add',
            category: 'abandoned',
            name: $('#addAbandoned input[name="name"]').val(),
            platform: $('#addAbandoned input[name="platform"]').val(),
            note: $('#addAbandoned textarea').val()
        }, function (data) {
            if (data == "success") {

                $('#abandoned').append(" <li title=\"" + $('#addAbandoned input[name="name"]').val() + "\">" + $('#addAbandoned input[name="name"]').val() + " <a href=\"#\"><span class='deleteButton'>&#x2716;</span></a> <span>" + $('#addAbandoned input[name="platform"]').val() + "</span><span>" + $('#addAbandoned textarea').val() + "</span></li>");

                $(':input', '#addAbandoned').not(':button, :submit, :reset, :hidden').val('').removeAttr('checked').removeAttr('selected');
                //hideForm();


            } else {
                alert(data);
            };
            //alert(data);
        });
    });

    $('#addUnbeaten').submit(function (event) {

        event.preventDefault();

        $.post("api.php", {
            action: 'add',
            category: 'unbeaten',
            name: $('#addUnbeaten input[name="name"]').val(),
            platform: $('#addUnbeaten input[name="platform"]').val(),
            note: $('#addUnbeaten textarea').val()
        }, function (data) {
            if (data == "success") {

                $('#unbeaten').append(" <li title=\"" + $('#addUnbeaten input[name="name"]').val() + "\">" + $('#addUnbeaten input[name="name"]').val() + " <a href=\"#\"><span class='deleteButton'>&#x2716;</span></a> <span class=\"platform\">" + $('#addUnbeaten input[name="platform"]').val() + "</span><span class=\"note\">" + $('#addUnbeaten textarea').val() + "</span></li>");

                $(':input', '#addUnbeaten').not(':button, :submit, :reset, :hidden').val('').removeAttr('checked').removeAttr('selected');
                //hideForm();


            } else {
                alert(data);
            };
            //alert(data);
        });
    });

    $('#addBeaten').submit(function (event) {

        event.preventDefault();

        $.post("api.php", {
            action: 'add',
            category: 'beaten',
            name: $('#addBeaten input[name="name"]').val(),
            platform: $('#addBeaten input[name="platform"]').val(),
            note: $('#addBeaten textarea').val()
        }, function (data) {
            if (data == "success") {

                $('#beaten').append(" <li title=\"" + $('#addBeaten input[name="name"]').val() + "\" >" + $('#addBeaten input[name="name"]').val() + " <a class=\"delete_link\" href=\"#\"><span class='deleteButton'>&#x2716;</span></a> <span>" + $('#addBeaten input[name="platform"]').val() + "</span><span>" + $('#addBeaten textarea').val() + "</span></li>");

				

                $(':input', '#addBeaten').not(':button, :submit, :reset, :hidden').val('').removeAttr('checked').removeAttr('selected');
                //hideForm();
				

            } else {
                alert(data);
            };
            //alert(data);
        });
    });



    $('.editLink').click(function () {
        
        
        editToggle();
    });


    $('span.deleteButton').live('click', function () {

        var liThing = $(this).closest("li");

        $.post("api.php", {
            action: 'remove',
            category: $(this).closest("div").attr("id"),
            name: $(this).closest("li").attr("title")
        }, function (data) {
            if (data == "success") {


                liThing.fadeOut();



            } else {

                alert('fail');
                alert(data);
            };
            //alert(data);
        });

    });



    function hideForm() {

        $('form').slideUp();

    };


    function editToggle() {
    
    	$('.deleteButton').fadeToggle('fast', function () {
    	    // Animation complete
    	});
    
    	if($editing == false){
    	
    		
    		$('li', 'div.category').draggable({
    		        cancel: "a.delete_button",
    		        // clicking an icon won't initiate dragging
    		        revert: "invalid",
    		        // when not dropped, the item will revert back to its initial position
    		        containment: $("#demo-frame").length ? "#demo-frame" : "document",
    		        // stick to demo-frame if present
    		        helper: "clone",
    		        cursor: "move",
    		        disabled: false
    		    });
    		
    		
    		    $('div.category').droppable({
    		        accept: "div.category > li",
    		        hoverClass: "drop_hover",
    		        drop: function (event, ui) {
    		            moveItem(ui.draggable, $(this));
    		
    		        },
    		        disabled: false
    		    });
    		    
    		    $editing = true;
    		    
    		    
    		
    	}else{
    	
    		$('li', 'div.category').draggable({ disabled: true });
    		
    		$('div.category').droppable({ disabled: true });
    		    		
    		$editing = false;
    		
    	};
    
    };
    



});


function moveItem($item, $category) {

    $.post("api.php", {
        action: 'remove',
        category: $item.closest("div").attr("id"),
        name: $item.closest("li").attr("title")
    }, function (data) {
        if (data == "success") {


            //var $platform = $('span.deleteButton');

            $.post("api.php", {
                action: 'add',
                category: $category.attr('id'),
                name: $item.closest("li").attr("title"),
                platform: $item.closest("li").children('span.platform').html(),
                note: $item.closest("li").children('span.note').html()
            }, function (data) {
                if (data == "success") {


                    $category.append($item);



                } else {
                    alert(data);
                };

            });

        } else {

            alert('fail');
            alert(data);
        };
        //alert(data);
    });

};
