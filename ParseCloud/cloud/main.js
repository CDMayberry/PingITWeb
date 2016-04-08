
// Use Parse.Cloud.define to define as many cloud functions as you want.
// For example:
Parse.Cloud.afterSave( "Pings", function(request) {

	//Get value from Ticket Object
	var message = request.object.get("Message");
	var userRel = request.object.relation("User").query();


	userRel.first().then(function(user) {
		//console.log("User: " + JSON.stringify(user));
		//console.log("User Email Function Test: " + user.getEmail());
			//Set push query
		if (typeof user.id !== 'undefined') {		
			var pushQuery = new Parse.Query(Parse.Installation);
			pushQuery.limit = 1;
			pushQuery.descending("updatedAt");
			pushQuery.equalTo("user", user);

			//Send Push message
			Parse.Push.send({
				where: pushQuery,
				data: {
					alert: message,
					//title: "TLC Helpdesk",
					sound: "default"
				}
			});
			
			if(user.get('resendDelay') > 0) {
				var minToMilli=60000;//millisecs]
				var date = new Date();
                //console.log("Offset: "+date.getTimezoneOffset())
				var delay = new Date(date.getTime() + (user.get('resendDelay') * minToMilli));
                //console.log("Right now: "+date+"; in ISO: "+date.toISOString())
                //console.log("Delay: "+delay+"; ISO: "+delay.toISOString()+")
                
				Parse.Push.send({
                    where: pushQuery,
                    push_time: delay.toISOString(),
                    data: {
                        alert: message,
                        //title: "TLC Helpdesk",
                        sound: "default"
                    }
                });
			}
			
		}
		else
		{
			 console.log("Error: No user id found");
		}
	});

});

Parse.Cloud.afterSave( "Annoucement", function(request) {

	//Get value from Ticket Object
	var message = request.object.get("Message");

	//Set push query
	var pushQuery = new Parse.Query(Parse.Installation);

	//Send Push message
	Parse.Push.send({
		where: pushQuery,
		data: {
			alert: message,
			//title: "TLC Helpdesk",
			sound: "default"
		}
	});
});

Parse.Cloud.beforeSave(Parse.User, function(request, response) {
	
	//console.log("Checking user resend");
	
	if (!request.object.get("resendDelay")) {
		//console.log("Setting default resend");
		request.object.set("resendDelay", 0);
	}

	response.success();
});