
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
			
			/*pushQuery.find({
				success: function(results) {
					console.log ("Results count is  " + results.length);
					console.log ("Object Looks Like: " + JSON.stringify(results));
					
					//response.success();
				},
				error: function() {
					console.log("We got no user related to userID(" + user.id + ")");
					//response.error("No driver related to userID");
				}
			}); */

			//console.log("Limit: " + pushQuery.limit);
			//console.log("UserId: " + user.id);

			//Send Push message
			Parse.Push.send({
				where: pushQuery,
				data: {
					alert: message,
					//title: "TLC Helpdesk",
					sound: "default"
				}
			});
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