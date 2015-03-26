var request = {
	serveraddress: "http://localhost/vacancymanagement/server/controller/",

	getURL: function(controller) {
		return this.serveraddress + controller;
	},

	registerEnterprise: function(username, password, mail, website) {
		return eval('(' + $.ajax({ type: "GET",   
	         url: this.getURL("enterpriseregistration.php"),
	         data: { username: username, password: password, mail: mail, website: website },
	         async: false
		}).responseText + ')');
	},

	validateEnterpriseRegistration: function(id, code) {
		return eval('(' + $.ajax({ type: "GET",   
	         url: this.getURL("validateenterpriseregistration.php"),
	         data: { id: id, code: code },
	         async: false
		}).responseText + ')');
	},

	login: function(username, password) {
		var cryptedpassword = SHA1(password);

		var result = eval('(' + $.ajax({ type: "GET",   
			url: this.getURL("login.php"),
			data: { username: username, password: cryptedpassword },
			async: false
		}).responseText + ')');

		console.log("login request", "username: ", username, "password (crypted): ", cryptedpassword, "result status: ", result.status);

		return result;
	},

	disconnect: function() {
		return eval('(' + $.ajax({ type: "GET",   
			url: this.getURL("disconnect.php"),
			async: false
		}).responseText + ')');
	},

	getUserData: function() {
		var sessionid = $.cookie('PHPSESSID');

		var result = eval('(' + $.ajax({ type: "GET",   
			url: this.getURL("getuserdata.php"),
			data: { 'sessionid': sessionid },
			async: false
		}).responseText + ')');

		console.log('get user data', 'sessionid: ', sessionid, "result status: ", result.status);

		if(result.status) {
			console.log('result values: ', result.values);
		}

		return result;
	},

	getStages: function() {
		return eval('(' + $.ajax({ type: "GET",   
			url: this.getURL("getstages.php"),
			async: false
		}).responseText + ')');
	},

	getStagesFromEnterprise: function() {
		var result = eval('(' + $.ajax({ type: "GET",   
			url: this.getURL("getstagesfromenterprise.php"),
			async: false
		}).responseText + ')');

		console.log('request stages from enterprise', 'status: ' + result.status + ' result: ' + result.values);

		return result;
	},

	getEnterpriseRegistration: function() {
		return eval('(' + $.ajax({ type: "GET",
			url: this.getURL("getenterpriseregistration.php"),
			async: false
		}).responseText + ')');
	},

	manualEnterpriseRegistrationValidation: function(enterpriseregistrationid) {
		var result = eval('(' + $.ajax({ type: "GET",   
			url: this.getURL("manualenterpriseregistrationvalidation.php"),
			data: { id: enterpriseregistrationid },
			async: false
		}).responseText + ')');

		console.log('manual enterprise registration validation', enterpriseregistrationid, 'result', result.status);
		console.log('values', result.values);

		return result;
	},

	manualEnterpriseRegistrationRefuse: function(enterpriseregistrationid) {
		return eval('(' + $.ajax({ type: "GET",   
			url: this.getURL("manualenterpriseregistrationrefuse.php"),
			data: { id: enterpriseregistrationid },
			async: false
		}).responseText + ')');
	},

	inviteWithPhoneNumbers: function(phonenumbers) {
		return eval('(' + $.ajax({ type: "GET",   
			url: this.getURL("invitewithphonenumbers.php"),
			data: { phonenumbers: phonenumbers },
			async: false
		}).responseText + ')');
	},

	checkConnection: function() {
		var result = eval('(' + $.ajax({ type: "GET",   
			url: this.getURL("checkconnection.php"),
			async: false
		}).responseText + ')');

		console.log('check connection request', result.status);

		if(result.status) console.log('values', result.values);

		return result;
	},

	getUserId: function() {
		var result = eval('(' + $.ajax({ type: "GET",   
			url: this.getURL("getuserid.php"),
			async: false
		}).responseText + ')');

		console.log('get user id request', result.status);

		if(result.status) console.log('values', result.values);

		return result;
	},

	addStage: function(name, description, placenumber) {
		var result = eval('(' + $.ajax({ type: "GET",   
			url: this.getURL("addstage.php"),
			data: { name: name, description: description, placenumber: placenumber },
			async: false
		}).responseText + ')');

		console.log('get user id request', result.status);

		if(result.status) console.log('values', result.values);

		return result;
	},

	addStudent: function(type, table) {
		var result = eval('(' + $.ajax({ type: "GET",   
			url: this.getURL("addstudent.php"),
			data: {
				type: type,
				table: table
			},
			async: false
		}).responseText + ')');

		console.log(result.status, result.values);

		return result;
	},

	validateStudentSession: function(id, code, password) {
		var result = eval('(' + $.ajax({ type: "GET",   
			url: this.getURL("validatestudentsession.php"),
			data: {
				id: id,
				code: code,
				password: password
			},
			async: false
		}).responseText + ')');

		console.log('debug', result.status, result.values);

		return result;
	},

	candidate: function(id) {
		var result = eval('(' + $.ajax({ type: "GET",   
			url: this.getURL("candidate.php"),
			data: {
				id: id
			},
			async: false
		}).responseText + ')');

		console.log('debug', result.status, result.values);

		return result;
	},

	getCandidatedStages: function() {
		var result = eval('(' + $.ajax({ type: "GET",   
			url: this.getURL("getcandidatedstages.php"),
			async: false
		}).responseText + ')');

		console.log('debug', result.status, result.values);

		return result;
	},

	publication: function(id) {
		var result = eval('(' + $.ajax({ type: "GET",   
			url: this.getURL("publication.php"),
			data: { id: id },
			async: false
		}).responseText + ')');

		console.log('debug', result.status, result.values);

		return result;
	},

	getCandidature: function(id) {
		var result = eval('(' + $.ajax({ type: "GET",   
			url: this.getURL("getcandidatures.php"),
			data: { id: id },
			async: false
		}).responseText + ')');

		console.log('debug get candidatures', result.status, result.values);

		return result;
	},

	getProfil: function() {
		var result = eval('(' + $.ajax({ type: "GET",   
			url: this.getURL("getprofil.php"),
			async: false
		}).responseText + ')');

		console.log('debug get profil', 'result', result.status, result.values);

		return result;
	},

	setSkills: function(skills) {
		var result = eval('(' + $.ajax({ type: "GET",   
			url: this.getURL("setskills.php"),
			data: { skills: skills },
			async: false
		}).responseText + ')');

		console.log('debug set skills', ' skills ', skills, ' result ', result.status, result.values);

		return result;
	},

	getSkills: function() {
		var result = eval('(' + $.ajax({ type: "GET",   
			url: this.getURL("getskills.php"),
			async: false
		}).responseText + ')');

		console.log('debug get skills', ' result ', result.status, result.values);

		return result;
	},

	getFormatedSkills: function(userid) {
		var result = eval('(' + $.ajax({ type: "GET",   
			url: this.getURL("getformatedskills.php"),
			data: { userid: userid },
			async: false
		}).responseText + ')');

		console.log('debug get formated skills', ' result ', result.status, result.values);

		return result;
	},

	getFormatedGraduate: function(userid) {
		var result = eval('(' + $.ajax({ type: "GET",   
			url: this.getURL("getformatedgraduate.php"),
			data: { userid: userid },
			async: false
		}).responseText + ')');

		console.log('debug get formated graduate', ' result ', result.status, result.values);

		return result;
	},

	searchStudents: function(graduate, skills) {
		var result = eval('(' + $.ajax({ type: "GET",   
			url: this.getURL("searchstudents.php"),
			data: { graduate: graduate, skills: skills },
			async: false
		}).responseText + ')');

		console.log('debug search student', ' graduate ', graduate, ' skills ', skills, ' result ', result.status, result.values);

		return result;
	},

	searchStudentsWithGraduate: function(graduate) {
		var result = eval('(' + $.ajax({ type: "GET",   
			url: this.getURL("searchstudentswithgraduate.php"),
			data: { graduate: graduate },
			async: false
		}).responseText + ')');

		console.log('debug search student with graduate', ' graduate ', graduate, ' result ', result.status, result.values);

		return result;
	},

	searchStudentsWithSkills: function(skills) {
		var result = eval('(' + $.ajax({ type: "GET",   
			url: this.getURL("searchstudentswithskills.php"),
			data: { skills: skills },
			async: false
		}).responseText + ')');

		console.log('debug search student with skills', ' skills ', skills, ' result ', result.status, result.values);

		return result;
	}
};