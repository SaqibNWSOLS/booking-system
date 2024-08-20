(function () {
		scheduler.locale.labels.section_text = 'Customer';
	scheduler.locale.labels.section_room = 'Property';
	scheduler.locale.labels.section_status = 'Status';
	scheduler.locale.labels.section_is_paid = 'Paid';
	scheduler.locale.labels.section_time = 'Dates';
	scheduler.locale.labels.section_amount = 'Amount';
		scheduler.locale.labels.section_amount_recieved = 'Amount Recieved';
	scheduler.locale.labels.section_capacity = 'Capacity';
	scheduler.locale.labels.section_discount = 'Discount %';
	scheduler.locale.labels.section_special_cleaning_fee = 'Special Cleaning Fee';
	scheduler.xy.scale_height = 30;
	scheduler.config.details_on_dblclick = true;
	scheduler.config.prevent_cache = true;
	scheduler.config.show_loading = true;
	scheduler.config.drag_move = false;
	scheduler.config.dblclick_update= true;
	scheduler.config.drag_create = true;
	scheduler.config.drag_resize = true;
		scheduler.config.multi_day_height_limit = true;
		scheduler.config.drag_highlight=true;
	scheduler.config.drag_lightbox=true;
	scheduler.config.dblclick_create=true;
  
	scheduler.config.xml_date = "%Y-%m-%d %H:%i";

	var roomsArr = scheduler.serverList("room");
	var roomTypesArr = scheduler.serverList("roomType");
	var roomStatusesArr = scheduler.serverList("roomStatus");
	var bookingStatusesArr = scheduler.serverList("bookingStatus");

scheduler.form_blocks["my_editor"]={
    render:function(sns){
        return "<div class='dhx_cal_ltext' style='height:27px;'><input name='amount' readonly type='number' style='width:100%'></div>";
    },
    set_value:function(node,value,ev){
        node.querySelector("[name='amount']").value = value||"";
    },
    get_value:function(node,ev){
        return node.querySelector("[name='amount']").value;
    },
    focus:function(node){
        var input = node.querySelector("[name='amount']"); 
        input.select(); 
        input.focus(); 
    }
};
	scheduler.config.lightbox.sections = [
		{map_to: "text", name: "text", type: "select", options: scheduler.serverList("customers")},
		{map_to: "room", name: "room", type: "select", options: scheduler.serverList("currentRooms")},
		{map_to: "capacity", name: "capacity", type: "my_editor", height:"30",style:"readonly"},
		{map_to: "amount", name: "amount", type: "my_editor", height:"30"},
		{map_to: "amount_recieved", name: "amount_recieved", type: "my_editor", height:"40"},
		{map_to: "discount", name: "discount", type: "my_editor", height:"30"},
		{map_to: "special_cleaning_fee", name: "special_cleaning_fee", type: "my_editor", height:"50"},
		{map_to: "status", name: "status", type: "radio", options: scheduler.serverList("bookingStatus")},
		{map_to: "time", name: "time", type: "calendar_time"}
	];


	scheduler.locale.labels.timeline_tab = 'Timeline';

	scheduler.createTimelineView({
		fit_events: true,
		name: "timeline",
		y_property: "room",
		render: 'bar',
		x_unit: "day",
		columns :10,
		x_start:0,
		x_step :1,
		x_start :1,
		x_length:1,
		x_date: "%d",
		x_size: 45,
		dy: 40,
		event_dy: 35,
		section_autoheight: false,
		round_position: true,

		y_unit: scheduler.serverList("currentRooms"),
		second_scale: {
			x_unit: "month",
			x_date: "%F %Y"
		}
	});

	function findInArray(array, key) {
		for (var i = 0; i < array.length; i++) {
			if (key == array[i].key)
				return array[i];
		}
		return null;
	}

	function getRoomType(key) {
		return findInArray(roomTypesArr, key).label;
	}

	function getRoomStatus(key) {
		return findInArray(roomStatusesArr, key);
	}

	function getRoom(key) {
		return findInArray(roomsArr, key);
	}

	scheduler.templates.timeline_scale_label = function (key, label, section) {
		var roomStatus = getRoomStatus(section.status);
		return ["<div class='timeline_item_separator'></div>",
			"<div class='timeline_item_cell room_status'>",
			"<span class='room_status_indicator room_status_indicator_" + roomStatus.key + "'></span>",
			"<span>" + label + "</span>",
			"</div>"].join("");
	};

	scheduler.date.timeline_start = scheduler.date.day_start;
	scheduler.date.add_timeline = function (date, step) {
		return scheduler.date.add(date, step, "month");
	};

	scheduler.attachEvent("onBeforeViewChange", function (old_mode, old_date, mode, date) {
		var startDate = moment();
        var endDate = moment().add('months', 2);
		var year = date.getFullYear();
		var month = (date.getMonth() + 1);
		var d = new Date(year, month, 0);
		var daysInMonth = d.getDate();
		scheduler.matrix["timeline"].x_size = endDate.diff(startDate, 'days');
		return true;
	});

	scheduler.templates.event_class = function (start, end, event) {
		return "event_" + (event.status || "");
	};

	function getBookingStatus(key) {
		var bookingStatus = findInArray(bookingStatusesArr, key);
		return !bookingStatus ? '' : bookingStatus.label;
	}

	function getPaidStatus(isPaid) {
		return isPaid ? "Paid" : "Unpaid";
	}

	var eventDateFormat = scheduler.date.date_to_str("%d %M %Y");
	scheduler.templates.event_bar_text = function (start, end, event) {
		var paidStatus = getPaidStatus(event.is_paid);
		var startDate = eventDateFormat(event.start_date);
		var endDate = eventDateFormat(event.end_date);
		return [event.customer_name+ "<br />",
			startDate + " - " + endDate,
			].join("");
	};

	scheduler.templates.tooltip_text = function (start, end, event) {
		var room = getRoom(event.room) || {label: ""};
		var html = [];
		html.push("Customer: <b>" + event.customer_name + "</b>");
		html.push("Property: <b>" + room.label + "</b>");
		html.push("Capacity: <b>" + event.capacity + "</b>");
		html.push("Amount: <b>" + event.amount + "</b>");
		html.push("Amount Recieved: <b>" + event.amount_recieved + "</b>");
		html.push("Discount %: <b>" + event.discount + "</b>");
		html.push("Special Cleaning Fee: <b>" + event.special_cleaning_fee + "</b>");
		html.push("Check-in: <b>" + eventDateFormat(start) + "</b>");
		html.push("Check-out: <b>" + eventDateFormat(end) + "</b>");
		html.push(getBookingStatus(event.status) + ", " + getPaidStatus(event.is_paid));
		return html.join("<br>")
	};

	scheduler.templates.lightbox_header = function (start, end, ev) {
		var formatFunc = scheduler.date.date_to_str('%d.%m.%Y');
		return formatFunc(start) + " - " + formatFunc(end);
	};

	scheduler.attachEvent("onEventCollision", function (ev, evs) {
		for (var i = 0; i < evs.length; i++) {
			if (ev.room != evs[i].room) continue;
			dhtmlx.message({
				type: "error",
				text: "This room is already booked for this date."
			});
		}
		return true;
	});

	scheduler.attachEvent('onEventCreated', function (event_id) {
		
         localStorage.setItem('eventId',event_id);
		var ev = scheduler.getEvent(event_id);
		roomDetail=getRoom(ev.room);
		if(roomDetail.status==1){
		showModal(ev);
	    } else {
	    	 scheduler.deleteEvent(localStorage.getItem('eventId'));
                      Swal.fire(
                    'Warning!',
                    'Property is not available for booking.',
                    'warning'
                );
	    }
		ev.status = 0;
		ev.is_paid = false;
		ev.text = 'new reservation';
	});

	scheduler.addMarkedTimespan({days: [0, 6], zones: "fullday", css: "timeline_weekend"});

	window.updateSections = function updateSections(value) {
		var currentRoomsArr = [];
		if (value == 'all') {
			scheduler.updateCollection("currentRooms", roomsArr.slice());
			return
		}
		for (var i = 0; i < roomsArr.length; i++) {
			if (value == roomsArr[i].type) {
				currentRoomsArr.push(roomsArr[i]);
			}
		}
		scheduler.updateCollection("currentRooms", currentRoomsArr);
	};

	scheduler.attachEvent("onXLE", function () {
		updateSections("all");
		var select = document.getElementById("room_filter");
		var selectHTML = ["<option value='all'>All</option>"];
		for (var i = 0; i < roomTypesArr.length + 0; i++) {
			selectHTML.push("<option value='" + roomTypesArr[i].key + "'>" + getRoomType(roomTypesArr[i].key) + "</option>");
		}
		select.innerHTML = selectHTML.join("");
	});

	scheduler.attachEvent("onEventSave", function (id, ev, is_new) {
		console.log(typeof ev.capacity );
		if (!ev.text) {
			dhtmlx.alert("Please choose a Customer");
			return false;
		}
		if (!ev.capacity) {
			dhtmlx.alert("Please enter capacity");
			return false;
		}
		if (!ev.amount) {
			dhtmlx.alert("Please enter amount");
			return false;
		}

		
		return true;
	});

})();

function init() {
	scheduler.init('scheduler_here', new Date(), "timeline");
	scheduler.load("./data.php", "json");
     console.log(scheduler);
	scheduler._update_timeline_section = function(){
	/*if(scheduler.getState().drag_mode != 'resize'){
		return old_timeline_section.apply(this, arguments);
	}*/
	
};
scheduler.attachEvent("onBeforeEventChanged", function(ev, e, is_new, original){
    if(moment(ev.end_date).isBefore(original.end_date) && ev.status  && ev.status!=0){
           return false;
    }
    return true;
});
	window.dp = new dataProcessor("./data.php");
	dp.init(scheduler);
	(function () {
		var element = document.getElementById("scheduler_here");
		var top = scheduler.xy.nav_height + 1 + 1;// first +1 -- blank space upper border, second +1 -- hardcoded border length
		var height = scheduler.xy.scale_height;
		var width = scheduler.matrix.timeline.dx;
		var header = document.createElement("div");
		header.className = "collection_label";
		header.style.position = "absolute";
		header.style.top = top + "px";
		header.style.width = width + "px";
		header.style.height = height + "px";

		var descriptionHTML = "<div class='timeline_item_separator'></div>" +
			"<div class='timeline_item_cell'>Property</div>";
		header.innerHTML = descriptionHTML;
		element.appendChild(header);
	})();
}

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function showModal(ev){
	console.log(ev.room);
	 $('#grant-chat--modal').modal('show');
         
        if ($('#search_checkin, #search_checkout').length) {
                    // check if element is available to bind ITS ONLY ON HOMEPAGE
                    var currentDate = moment().format("DD-MM-YYYY");
                    start=ev.start_date;
                    end=ev.end_date;
                    $('#search_checkin').daterangepicker({
                        locale: {
                            format: 'DD-MM-YYYY'
                        },
                        "opens": "center",
						"drops": "up",
                        "alwaysShowCalendars": true,
                        "minDate": currentDate,
                        "maxDate": moment().add('months', 2).subtract('days', 1),
                        "maxSpan": {
                            "months": 12
                        },
                        autoApply: true,
                        autoUpdateInput: false
                    }, function(start, end, label) {
                        // console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
                        // Lets update the fields manually this event fires on selection of range
                        var selectedStartDate =start.format("DD-MM-YYYY"); // selected start
                        var selectedEndDate = end.format('DD-MM-YYYY'); // selected end

                        $checkinInput = $('#search_checkin');
                        $checkoutInput = $('#search_checkout');

                        // Updating Fields with selected dates
                        $checkinInput.val(selectedStartDate);
                        $checkoutInput.val(selectedEndDate);

                        // Setting the Selection of dates on calender on CHECKOUT FIELD (To get this it must be binded by Ids not Calss)
                        var checkOutPicker = $checkoutInput.data('daterangepicker');
                        console.log(selectedStartDate);
                        checkOutPicker.setStartDate(selectedStartDate);
                        checkOutPicker.setEndDate(selectedEndDate);

                        // Setting the Selection of dates on calender on CHECKIN FIELD (To get this it must be binded by Ids not Calss)
                        var checkInPicker = $checkinInput.data('daterangepicker');
                        checkInPicker.setStartDate(selectedStartDate);
                        checkInPicker.setEndDate(selectedEndDate);

                    });

                    $('#search_checkout').daterangepicker({
                        locale: {
                            format: 'DD-MM-YYYY'
                        },
                        "opens": "center",
						"drops": "up",
                        "alwaysShowCalendars": true,
                        "minDate": currentDate,
                        "maxDate": moment().add('months', 2).subtract('days', 1),
                        "maxSpan": {
                            "months": 12
                        },
                        autoApply: true,
                        autoUpdateInput: false
                    }, function(start, end, label) {
                        // console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
                        // Lets update the fields manually this event fires on selection of range
                        var selectedStartDate =start.format('DD-MM-YYYY');  // selected start
                        var selectedEndDate = end.format('DD-MM-YYYY'); // selected end
                        $checkinInput = $('#search_checkin');
                        $checkoutInput = $('#search_checkout');

                        // Updating Fields with selected dates
                        $checkinInput.val(selectedStartDate);
                        $checkoutInput.val(selectedEndDate);

                        // Setting the Selection of dates on calender on CHECKOUT FIELD (To get this it must be binded by Ids not Calss)
                        var checkOutPicker = $checkoutInput.data('daterangepicker');
                        checkOutPicker.setStartDate(selectedStartDate);
                        checkOutPicker.setEndDate(selectedEndDate);

                        // Setting the Selection of dates on calender on CHECKIN FIELD (To get this it must be binded by Ids not Calss)
                        var checkInPicker = $checkinInput.data('daterangepicker');
                        checkInPicker.setStartDate(selectedStartDate);
                        checkInPicker.setEndDate(selectedEndDate);

                    });

                    $('#search_checkout').add("#search_checkin").on('showCalendar.daterangepicker', function(ev,
                        picker) {
                        picker.container.find('.drp-calendar').on('mouseup.daterangepicker', 'td.available',
                            function() {
                                //   picker.maxDate = true;
                                picker.updateCalendars();
                            });
                    });

                }
                 $checkinInput = $('#search_checkin');
                var checkInPicker = $checkinInput.data('daterangepicker');
                        checkInPicker.setStartDate(ev.start_date);
                        checkInPicker.setEndDate(ev.end_date);
      $('#search_checkin').val(moment(ev.start_date).format("DD-MM-YYYY"));
            $('#search_checkout').val(moment(ev.end_date).format("DD-MM-YYYY"));
$('#property_ids option')
     .removeAttr('selected')
     .filter('[value='+ev.room+']')
         .attr('selected', true);
           $(".select-2").select2({
         dropdownParent: $('#grant-chat--modal')
      });
       
         getPropertyPrices(ev.room);
     }