jQuery.post(
	 ajaxStuff.ajaxurl,
	 {
		 action : 	'ajax_action',
		 nonce : 	ajaxStuff.nonce,
		 data: 		someDataObj
	 },
	 function( response ) {
		console.log( response );
	 }
);