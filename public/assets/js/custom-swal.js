// function notify(e) {
// 	var t = document.querySelector("body"),
// 		a = document.createElement("div");
// 	a.classList.add("alert", "position-absolute", "top-0", "border-0", "text-white", "w-50", "end-0", "start-0", "mt-2", "mx-auto", "py-2"), a.classList.add("alert-" + e.getAttribute("data-type")), a.style.transform = "translate3d(0px, 0px, 0px)", a.style.opacity = "0", a.style.transition = ".35s ease", a.style.zIndex = "9999", setTimeout(function() {
// 		a.style.transform = "translate3d(0px, 20px, 0px)", a.style.setProperty("opacity", "1", "important")
// 	}, 100), a.innerHTML = '<div class="d-flex mb-1"><div class="alert-icon me-1"><i class="' + e.getAttribute("data-icon") + ' mt-1"></i></div><span class="alert-text"><strong>' + e.getAttribute("data-title") + '</strong></span></div><span class="text-sm">' + e.getAttribute("data-content") + "</span>", t.appendChild(a), setTimeout(function() {
// 		a.style.transform = "translate3d(0px, 0px, 0px)", a.style.setProperty("opacity", "0", "important")
// 	}, 4e3), setTimeout(function() {
// 		e.parentElement.querySelector(".alert").remove()
// 	}, 4500)
// }



var notif = {

    showNotification: function(from, align, message, color) {
        color = color;

        $.notify({
			// options
			icon: 'fas fa-bell',
			message: message,
			
		},{
			type: color,
			timer: 8000,
			animate: {
				enter: 'animated fadeInUp',
			  },
			placement: {
				from: from,
				align: align,
				
			},
			template: '<div data-notify="container" class="col-5 alert alert-{0}" role="alert">' +
			'<i class="fas fa-times text-white close" data-notify="dismiss"></i>' +
                 
		// '<button type="button" aria-hidden="true"" class="close" data-notify="dismiss">×</button>' +
		'<span data-notify="icon" class="text-white"></span> ' +
		'<span data-notify="title">{1}</span> ' +
		'<span data-notify="message" class="text-white">{2}</span>' +
		'<div class="progress" data-notify="progressbar">' +
			'<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
		'</div>' +
	
	'</div>' 
		});
    },

    
    showSwal: function(e) {
		if ("basic" == e) {
			const t = Swal.mixin({
				customClass: {
					confirmButton: "btn bg-gradient-info"
				}
			});
			t.fire({
				title: "Sweet!"
			})
		} else if ("title-and-text" == e) {
			const a = Swal.mixin({
				customClass: {
					confirmButton: "btn bg-gradient-success",
					cancelButton: "btn bg-gradient-danger"
				}
			});
			a.fire({
				title: "Sweet!",
				text: "Modal with a custom image.",
				imageUrl: "https://unsplash.it/400/200",
				imageWidth: 400,
				imageAlt: "Custom image"
			})
		} else if ("success-message" == e) Swal.fire("Good job!", "You clicked the button!", "success");
		else if ("warning-message-and-confirmation" == e) {
			const n = Swal.mixin({
				customClass: {
					confirmButton: "btn bg-gradient-success",
					cancelButton: "btn bg-gradient-danger"
				},
				buttonsStyling: !1
			});
			n.fire({
				title: "Are you sure?",
				text: "You won't be able to revert this!",
				type: "warning",
				showCancelButton: !0,
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel!",
				reverseButtons: !0
			}).then(e => {
				e.value ? n.fire("Deleted!", "Your file has been deleted.", "success") : e.dismiss === Swal.DismissReason.cancel && n.fire("Cancelled", "Your imaginary file is safe :)", "error")
			})
		} else if ("warning-message-and-cancel" == e) {
			const i = Swal.mixin({
				customClass: {
					confirmButton: "btn bg-gradient-success",
					cancelButton: "btn bg-gradient-danger"
				},
				buttonsStyling: !1
			});
			i.fire({
				title: "Are you sure?",
				text: "You won't be able to revert this!",
				icon: "warning",
				showCancelButton: !0,
				confirmButtonText: "Yes, delete it!"
			}).then(e => {
				e.isConfirmed && Swal.fire("Deleted!", "Your file has been deleted.", "success")
			})
		} 
		else if ("warning-message-and-cancel2" == e) {
			const i = Swal.mixin({
				customClass: {
					confirmButton: "btn bg-gradient-success",
					cancelButton: "btn bg-gradient-danger"
				},
				buttonsStyling: !1
			});
			i.fire({
				title: "Are you sure?",
				text: "You want to submit this record?",
				icon: "warning",
				showCancelButton: !0,
				confirmButtonText: "Yes, submit it!"
			}).then((result) => {
				if (result.isConfirmed) {
					Swal.fire("Saved!", "Your membership is now pending, please check your email for furthermore instruction regarding on your membership.", "success");
				setTimeout( function () { 
					$( "#applicantSave" ).trigger( "submit" );
				}, 3000);
			 
				}
				else{
					swal.close();
				}
				

				// $("#btnApplicantSave").click();
			})
		}
		else if ("insert-event" == e) {
			const i = Swal.mixin({
				customClass: {
					confirmButton: "btn bg-gradient-success",
					cancelButton: "btn bg-gradient-danger"
				},
				buttonsStyling: !1
			});
			i.fire({
				title: "Are you sure",
				text: "You want to save this event?",
				icon: "warning",
				showCancelButton: !0,
				confirmButtonText: "Yes, save it!"
			}).then((result) => {
				if (result.isConfirmed) {

					$("#loading").fadeIn();
				
					$(document).ready(function() {

						var event_date = $("#event_date").val();
						var start_time = $("#event_start").val();
						var end_time = $("#event_end").val();
						var momentObj = moment(event_date + start_time, 'YYYY-MM-DDLT');
						var momentObj2 = moment(event_date + end_time, 'YYYY-MM-DDLT');
						var event_venue = $("#event_venue").val();
						var event_description = $("#event_description").val();
						var event_price = $("#event_price").val();
						var event_limit = $("#event_limit").val();
						var event_points = $("#event_points").val();
						var session = $("#session").val();
						
						
						
						
						var token = $("#token").val();
						var urls = $( "#urlEvent" ).val();
						var title = $( "#title" ).val();
						var event_category = $( "#event_category" ).val();
						var start_dt = momentObj.format('YYYY-MM-DDTHH:mm:s');
						var end_dt = momentObj2.format('YYYY-MM-DDTHH:mm:s');
					
						$.ajaxSetup({
							headers: {
								'X-CSRF-TOKEN': token
							}
						});
						
						$.ajax({
							type : 'get',
							url: urls,
							data : { 'title' : title,
									 'category' : event_category,
									 'start_dt' : start_dt,
									 'end_dt' : end_dt,
									 'venue' : event_venue,
									 'description' : event_description,
									 'price' : event_price,
									 'participant_limit' : event_limit,
									 'points' : event_points,
									 'session' : session },
							success:function(res){
								$("#loading").fadeOut();
								Swal.fire({
									title: "Saved!",
									text: "New event successfuly added!",
									icon: "success",
									confirmButtonText: "Okay"
								}).then((result) => {
									if (result.isConfirmed) {
										window.location=res.url;
									}
									else{
										window.location=res.url;
									}
								});
								
																
							}
						});
					
					
					});
				
			 
				}
				else{
					swal.close();
				}
				

				// $("#btnApplicantSave").click();
			})
		}
		else if ("update-event" == e) {
			const i = Swal.mixin({
				customClass: {
					confirmButton: "btn bg-gradient-success",
					cancelButton: "btn bg-gradient-danger"
				},
				buttonsStyling: !1
			});
			i.fire({
				title: "Are you sure",
				text: "You want to update this event?",
				icon: "warning",
				showCancelButton: !0,
				confirmButtonText: "Yes, update it!"
			}).then((result) => {
				if (result.isConfirmed) {

					$("#loading").fadeIn();
				
					$(document).ready(function() {

						var event_date = $("#event_date_update").val();
					
						var start_time = $("#event_start_update").val();
						var end_time = $("#event_end_update").val();
						var momentObj = moment(event_date + start_time, 'YYYY-MM-DDLT');
						var momentObj2 = moment(event_date + end_time, 'YYYY-MM-DDLT');
						var event_venue = $("#event_venue_update").val();
						var event_description = $("#event_description_update").val();
						var event_price = $("#event_price_update").val();
						var event_limit = $("#event_limit_update").val();
						var event_points = $("#event_points_update").val();
						
						
						var id = $("#event_id_update").val();
						var token = $("#token_event_update").val();
						var urls = $( "#urlUpdateEvent" ).val();
						var title = $( "#title_update" ).val();
						var event_category = $( "#event_category_update" ).val();
						var status = $( "#event_status_update" ).val();
						
						var start_dt = momentObj.format('YYYY-MM-DDTHH:mm:s');
						var end_dt = momentObj2.format('YYYY-MM-DDTHH:mm:s');

					
						$.ajaxSetup({
							headers: {
								'X-CSRF-TOKEN': token
							}
						});
						
						$.ajax({
							type : 'get',
							url: urls,
							data : { 'title' : title,
									 'category' : event_category,
									 'start_dt' : start_dt,
									 'end_dt' : end_dt,
									 'venue' : event_venue,
									 'description' : event_description,
									 'price' : event_price,
									 'participant_limit' : event_limit,
									 'points' : event_points,
									 'id' : id,
									 'status' : status
									 },
							success:function(res){
								$("#loading").fadeOut();
								Swal.fire({
									title: "Updated!",
									text: "Event successfuly updated!",
									icon: "success",
									confirmButtonText: "Okay"
								}).then((result) => {
									if (result.isConfirmed) {
										window.location=res.url;
									}
									else{
										window.location=res.url;
									}
								});
								
																
							}
						});
					
					
					});
				
			 
				}
				else{
					swal.close();
				}
				

				// $("#btnApplicantSave").click();
			})
		}
		else if ("disapprove-member" == e) {
			const i = Swal.mixin({
				customClass: {
					confirmButton: "btn bg-gradient-success",
					cancelButton: "btn bg-gradient-danger"
				},
				buttonsStyling: !1
			});
			i.fire({
				title: "Are you sure",
				text: "You want to disapprove his/her member application?",
				icon: "warning",
				showCancelButton: !0,
				confirmButtonText: "Yes, Proceed!"
			}).then((result) => {
				if (result.isConfirmed) {

					$("#loading").fadeIn();
				
					$(document).ready(function() {

						var token = $("#token").val();
						var urls = $( "#urlDisapprove" ).val();
						var pps_no = $( "#pps_no" ).val();
						var disapprove_reason = $( "#disapprove_reason" ).val();
						var disapprove_by = $( "#disapprove_by" ).val();
						var email_address = $( "#email_address" ).val();
						var first_name = $( "#first_name" ).val();
						var last_name = $( "#last_name" ).val();

			
						$.ajaxSetup({
							headers: {
								'X-CSRF-TOKEN': token
							}
						});
						
						$.ajax({
							type : 'get',
							url: urls,
							data : { 'pps_no' : pps_no,
									 'disapprove_reason' : disapprove_reason,
									 'disapprove_by' : disapprove_by,
									 'email_address' : email_address,
									 'first_name' : first_name,
									 'last_name' : last_name
									
									 },
							success:function(res){
								$("#loading").fadeOut();
								Swal.fire({
									title: "Saved!",
									text: "Member successfully disapproved!",
									icon: "success",
									confirmButtonText: "Okay"
								}).then((result) => {
									if (result.isConfirmed) {
										window.location=res.url;
									}
									else{
										window.location=res.url;
									}
								});
								
																
							}
						});
					
					
					});
				
			 
				}
				else{
					swal.close();
				}
				

				// $("#btnApplicantSave").click();
			})
		}
		else if ("disapprove-member2" == e) {
			const i = Swal.mixin({
				customClass: {
					confirmButton: "btn bg-gradient-success",
					cancelButton: "btn bg-gradient-danger"
				},
				buttonsStyling: !1
			});
			i.fire({
				title: "Are you sure",
				text: "You want to disapprove his/her member application?",
				icon: "warning",
				showCancelButton: !0,
				confirmButtonText: "Yes, Proceed!"
			}).then((result) => {
				if (result.isConfirmed) {

					$("#loading2").fadeIn();
				
					$(document).ready(function() {

						var token = $("#token").val();
						var urls = $( "#urlDisapprove2" ).val();
						var pps_no = $( "#pps_no2" ).val();
						var disapprove_reason = $( "#disapprove_reason2" ).val();
						var disapprove_by = $( "#disapprove_by2" ).val();
						var email_address = $( "#email_address2" ).val();
						var first_name = $( "#first_name2" ).val();
						var last_name = $( "#last_name2" ).val();

			
						$.ajaxSetup({
							headers: {
								'X-CSRF-TOKEN': token
							}
						});
						
						$.ajax({
							type : 'get',
							url: urls,
							data : { 'pps_no' : pps_no,
									 'disapprove_reason' : disapprove_reason,
									 'disapprove_by' : disapprove_by,
									 'email_address' : email_address,
									 'first_name' : first_name,
									 'last_name' : last_name
									
									 },
							success:function(res){
								$("#loading2").fadeOut();
								Swal.fire({
									title: "Disapproved!",
									text: "Member successfully disapprove!",
									icon: "success",
									confirmButtonText: "Okay"
								}).then((result) => {
									if (result.isConfirmed) {
										window.location=res.url;
									}
									else{
										window.location=res.url;
									}
								});
								
																
							}
						});
					
					
					});
				
			 
				}
				else{
					swal.close();
				}
				

				// $("#btnApplicantSave").click();
			})
		}
		else if ("join-event" == e) {
			const i = Swal.mixin({
				customClass: {
					confirmButton: "btn bg-gradient-success",
					cancelButton: "btn bg-gradient-danger"
				},
				buttonsStyling: !1
			});
			i.fire({
				title: "Are you sure",
				text: "Do you want to join this event?",
				icon: "warning",
				showCancelButton: !0,
				confirmButtonText: "Yes, proceed"
			}).then((result) => {

				if (result.isConfirmed) {
					
					$("#loading").fadeIn();
						$(document).ready(function() {
							
							var token2 = $("#token2").val();
							var url = $( "#urlEventJoin" ).val();
							var pps_no = $( "#pps_no" ).val();
							var event_id = $( "#event_id" ).val();
							var points = $( "#points" ).val();
							var price = $( "#price" ).val();
							
							$.ajaxSetup({
								headers: {
									'X-CSRF-TOKEN': token2
								}
							});
							
							$.ajax({
								type : 'get',
								url: url,
								data : { 'pps_no' : pps_no,
										 'event_id' : event_id,
										 'points' : points,
										 'price' : price
										 },
								success:function(res){
									$("#loading").fadeOut();
									if(res.exist == true)
									{
										notif.showNotification('top', 'right', 'Warning, you already joined on this event!', 'warning');
									}
									else{
										if(res.amount == "free")
										{
											Swal.fire({
												customClass: {
													confirmButton: "btn bg-gradient-success",
													cancelButton: "btn bg-gradient-warning"
												},
												buttonsStyling: !1,
	
												title: "Success!",
												text: "You have been successfuly joined on this event!",
												icon: "success",
												confirmButtonText: "Okay",
												
											}).then((result) => {
												location.reload();
											});
										}

										else
										{
											Swal.fire({
												customClass: {
													confirmButton: "btn bg-gradient-success",
													cancelButton: "btn bg-gradient-warning"
												},
												buttonsStyling: !1,
	
												title: "Success!",
												text: "Member successfuly joined on this event, Please proceed for payment!",
												icon: "success",
												showCancelButton: true,
												showCancelButton: !0,
												confirmButtonText: "Pay now",
												cancelButtonText: "Pay later"
												
											}).then((result) => {
												if (result.isConfirmed) {
													var url = '/event-pay/'+res.event_transaction_id;
													window.location=url;
												}
												else{
													
													$("#eventDetailsRow").load(location.href + " #eventDetailsRow");
													
												}
											});
										}
										
										
									}
									
								}
							});
						
						
						});
					 
				
				}
				else{
					swal.close();
				}
			})
		}else if ("custom-html" == e) {
			const l = Swal.mixin({
				customClass: {
					confirmButton: "btn bg-gradient-success",
					cancelButton: "btn bg-gradient-danger"
				},
				buttonsStyling: !1
			});
			l.fire({
				title: "<strong>HTML <u>example</u></strong>",
				icon: "info",
				html: 'You can use <b>bold text</b>, <a href="//sweetalert2.github.io">links</a> and other HTML tags',
				showCloseButton: !0,
				showCancelButton: !0,
				focusConfirm: !1,
				confirmButtonText: '<i class="fa fa-thumbs-up"></i> Great!',
				confirmButtonAriaLabel: "Thumbs up, great!",
				cancelButtonText: '<i class="fa fa-thumbs-down"></i>',
				cancelButtonAriaLabel: "Thumbs down"
			})
		}
		else if ("custom-html2" == e) {
			const l = Swal.mixin({
				customClass: {
					confirmButton: "btn bg-gradient-success",
					cancelButton: "btn bg-gradient-danger"
				},
				buttonsStyling: !1
			});
			l.fire({
				title: "Are you sure",
				text: "You want to save this email?",	
				icon: "warning",
				showCloseButton: !0,
				showCancelButton: !0,
				focusConfirm: !1,
				confirmButtonText: '<i class="fa fa-floppy-o"></i> Save',
				// confirmButtonAriaLabel: "Thumbs up, great!",
				cancelButtonText: '<i class="fa fa-undo"></i> Cancel',
				// cancelButtonAriaLabel: "Thumbs down"
			}).then((result) => {
				if (result.isConfirmed) {
					$("#emailSaveForm").submit();
			 
				}
				else{
					swal.close();	
				}
				
				// $("#btnApplicantSave").click();
			})
		}
		else if ("custom-html3" == e) {
			const l = Swal.mixin({
				customClass: {
					confirmButton: "btn bg-gradient-success",
					cancelButton: "btn bg-gradient-danger"
				},
				buttonsStyling: !1
			});
			l.fire({
				title: "Are you sure",
				text: "You want to update this email?",	
				icon: "warning",
				showCloseButton: !0,
				showCancelButton: !0,
				focusConfirm: !1,
				confirmButtonText: '<i class="fa fa-floppy-o"></i> Update',
				// confirmButtonAriaLabel: "Thumbs up, great!",
				cancelButtonText: '<i class="fa fa-undo"></i> Cancel',
				// cancelButtonAriaLabel: "Thumbs down"
			}).then((result) => {
				if (result.isConfirmed) {
					$("#emailUpdateForm").submit();
			 
				}
				else{
					swal.close();	
				}
				

				// $("#btnApplicantSave").click();
			})
		} 
		else if ("rtl-language" == e) {
			const s = Swal.mixin({
				customClass: {
					confirmButton: "btn bg-gradient-success",
					cancelButton: "btn bg-gradient-danger"
				},
				buttonsStyling: !1
			});
			s.fire({
				title: "هل تريد الاستمرار؟",
				icon: "question",
				iconHtml: "؟",
				confirmButtonText: "نعم",
				cancelButtonText: "لا",
				showCancelButton: !0,
				showCloseButton: !0
			})
		} else if ("auto-close" == e) {
			let e;
			Swal.fire({
				title: "Auto close alert!",
				html: "I will close in <b></b> milliseconds.",
				timer: 2e3,
				timerProgressBar: !0,
				didOpen: () => {
					Swal.showLoading(), e = setInterval(() => {
						const e = Swal.getHtmlContainer();
						if (e) {
							const t = e.querySelector("b");
							t && (t.textContent = Swal.getTimerLeft())
						}
					}, 100)
				},
				willClose: () => {
					clearInterval(e)
				}
			}).then(e => {
				e.dismiss, Swal.DismissReason.timer
			})
		} else if ("input-field" == e) {
			const o = Swal.mixin({
				customClass: {
					confirmButton: "btn bg-gradient-success",
					cancelButton: "btn bg-gradient-danger"
				},
				buttonsStyling: !1
			});
			o.fire({
				title: "Submit your Github username",
				input: "text",
				inputAttributes: {
					autocapitalize: "off"
				},
				showCancelButton: !0,
				confirmButtonText: "Look up",
				showLoaderOnConfirm: !0,
				preConfirm: e => fetch(`//api.github.com/users/${e}`).then(e => {
					if (!e.ok) throw new Error(e.statusText);
					return e.json()
				}).catch(e => {
					Swal.showValidationMessage(`Request failed: ${e}`)
				}),
				allowOutsideClick: () => !Swal.isLoading()
			}).then(e => {
				e.isConfirmed && Swal.fire({
					title: `${e.value.login}'s avatar`,
					imageUrl: e.value.avatar_url
				})
			})
		}
	}
}







