// Umesh Sahu Developer
(function ($) {
	"use strict";

	$(document).ready(function () {
		$("#name_sd").attr("autofocus", true);
		$("#last_sd").attr("autofocus", true);
	});

	// Toolbar extra buttons
	var btnFinish = $('<button></button>').text('Submit')
		.addClass('btn btn-primary')
		.on('click', function (e) {
			e.preventDefault(); // Prevent the default form submission

			// Define an array to store the IDs of required fields
			var requiredFields = ["image_sd", 
								"name_sd", 
								"last_sd", 
								"number_sd", 
								"email_sd",
								"dateofbirth_sd", 
								"marital_status_dd", 
								"caste_dd", 
								"blood_group_dd", 
								"select_id_dd", 
								"id_number_dd", 
								"nationality_dd", 
								"country_dd", 
								"sts1", 
								"state1", 
								"pincode_dd", 
								"address_dd", 
								"doj_dd", 
								"emp_id_sd", 
								"shift_type_sd", 
								"country-dd1", 
								"state-dd1", 
								"desig-dd1", 
								"attendance_sd", 
								"reporting_manager_dd"];

			// Flag to check if all required fields are filled
			var allFieldsFilled = true;

			// Loop through the required fields

			for (var i = 0; i < requiredFields.length; i++) {
				var fieldId = requiredFields[i];

				// Check if the field is empty
				if ($('#' + fieldId).val() == "") {
					// Set the border color to red for the empty field
					$('#' + fieldId).css('border-color', 'red');
					console.log("empty: " + fieldId);
					allFieldsFilled = false;
				} else {
					// Reset the border color to the default (in case it was previously red)
					$('#' + fieldId).css('border-color', 'blue');
				}
			}
			if (allFieldsFilled) {
				// Continue with the form submission
				alert('Form  Submitted!');
				console.log("Submit ");
				$('#myForm').submit();
			} else {
				// Show an alert indicating that all required fields must be filled
				alert('Please fill in all required fields.');
			}
			// $('#myForm').submit();

		}); 
	// Toolbar extra buttons
	// var btnFinish = $('<button></button>').text('Submit')
	//     .addClass('btn btn-primary')
	//     .on('click', function (e) {
	//         e.preventDefault(); // Prevent the default form submission

	//         if (($('#name_sd').val() == "") || ($('#last_sd').val() == "")) {
	//             // Set the border color to red for the required field

	//             $('#name_sd').css('border-color', 'red');
	//             $('#last_sd').css('border-color', 'red');

	//             // Show an alert indicating the field is required
	//             alert('Input field is required!');
	//         } else {
	//             // Reset the border color to the default (in case it was previously red)
	//             $('#last_sd').css('border-color', 'blue');
	//             $('#name_sd').css('border-color', 'blue');

	//             // Continue with the form submission
	//             alert('Finish Clicked');
	//             console.log("Submit ");
	// 			$('#myForm').submit();
	//         }
	//     });

	var btnCancel = $('<button></button>').text('Submit')
		.addClass('btn btn-primary')
		.on('click', function () { $('.smartwizard-4').smartWizard(""); });


		// .on('click', function (e) {
		// 	e.preventDefault(); // Prevent the default form submission

		// 	// Define an array to store the IDs of required fields
		// 	var requiredFields = ["name_sd", "last_sd", "number_sd", "image_sd", "dateofbirth_sd", "email_sd", "country_sd", "sts1", "state1", "pincode_sd", "address_sd", "emp_id_sd", "shift_type_sd", "country-1dd", "state-1dd", "state-dd1", "country-dd1", "designation_id1", "desig-dd1", "doj_sd", "attendance_sd", "employee_type", "gender"];

		// 	// Flag to check if all required fields are filled
		// 	var allFieldsFilled = true;

		// 	// Loop through the required fields

		// 	for (var i = 0; i < requiredFields.length; i++) {
		// 		var fieldId = requiredFields[i];

		// 		// Check if the field is empty
		// 		if ($('#' + fieldId).val() == "") {
		// 			// Set the border color to red for the empty field
		// 			$('#' + fieldId).css('border-color', 'red');
		// 			console.log("empty: " + fieldId);
		// 			allFieldsFilled = false;
		// 		} else {
		// 			// Reset the border color to the default (in case it was previously red)
		// 			$('#' + fieldId).css('border-color', 'blue');
		// 		}
		// 	}
		// 	if (allFieldsFilled) {
		// 		// Continue with the form submission
		// 		alert('Finish Clicked');
		// 		console.log("Submit ");
		// 		$('#myForm').submit();
		// 	} else {
		// 		// Show an alert indicating that all required fields must be filled
		// 		alert('Please fill in all required fields.');
		// 	}

		// });

	// Smart Wizard
	$('.smartwizard').smartWizard({
		selected: 0,
		theme: 'default',
		transitionEffect: 'fade',
		showStepURLhash: true,
		toolbarSettings: {
			toolbarButtonPosition: 'end',
			toolbarExtraButtons: [btnFinish,]
		}
	});

	// Arrows Smart Wizard 1
	$('.smartwizard-1').smartWizard({
		selected: 0,
		theme: 'arrows',
		transitionEffect: 'fade',
		showStepURLhash: false,
		toolbarSettings: {
			toolbarExtraButtons: [btnFinish,]
		}
	});

	// Circles Smart Wizard 1
	$('.smartwizard-2').smartWizard({
		selected: 0,
		theme: 'circles',
		transitionEffect: 'fade',
		showStepURLhash: false,
		toolbarSettings: {
			toolbarExtraButtons: [btnFinish,]
		}
	});

	// Dots Smart Wizard 1
	$('.smartwizard-3').smartWizard({
		selected: 0,
		theme: 'dots',
		transitionEffect: 'fade',
		showStepURLhash: false,
		toolbarSettings: {

				toolbarExtraButtons: [btnFinish,]

		}
	});

	

	$('.smartwizard-4').smartWizard({
		selected: 0,
		theme: 'dots',
		transitionEffect: 'fade',
		showStepURLhash: false,
		toolbarSettings: {

			toolbarExtraButtons: [btnCancel,]
		}
	});

})(jQuery);
