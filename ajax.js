//You will want to wrap this whole thing with a function of some kind called by some event - like $('button').click(functionName); or any other event
jQuery.post( // <- this could also be jQuery.ajax or jQuery.get (or $.anyofthose - refer to jQuery codex for .ajax) if you have jQuery properly initialized
	// ajax URL from wp_localize function in enqueue_script hook
	 ajaxStuff.ajaxurl,
	 {
		 // action name givin in dynamic hook that starts with wp_ajax_ (basically everything after the wp_ajax_)
		 action : 	'ajax_action',
		 // reference to wp_localize object again, this time just the nonce key
		 nonce : 	ajaxStuff.nonce,
		 // you'll get your data object on the php side 
		 // (the callback referecenced in the 2nd parameter of the dynamic wp_ajax_ hook) by using the $_POST global varialbe like this -> $_POST['data']
		 data: 		someDataObj
	 },
	 function( response ) { 
		console.log( response ); // <- lets just see what we got - delete this after you get a good idea of what you are getting
		if(response == 'success'){
			// JS or jQuery Code you want to execute after successful response
		}
	 }
);