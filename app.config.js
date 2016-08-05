/*
 * Created By Bo Wang
 * Configure all back-end files' path in "HTTPConnect".
 * Set time for auto-logout in "CustIdleTime".
 */ 

(function() {
	'use strict';

	angular.module('myConfig')
	
	.constant('HTTPConnect', {

		login: './api/login.php',
		sendingEmail: './api/findPassword.php',

		// This is only used for local test, since user info has alreay been
		// stored in cookies after logging in.
		//getProfileInfo: './www/profileTest.php',

		getProfile: './api/getInfo.php',
		updateProfile: './api/update.php',

		// load data for employees' performance tracker
		// (Currently using JSON as an example)
		getEmployeePerformanceGroup: './jsons/empGroupTitles.json',
		getEmployeePerformanceDetails: './jsons/empTeaching.json',

		// load data for admin performance management
		// (Currently using JSON as an example)
		getAllPerformanceGroup: './jsons/adminGroupTitles.json',
		getTeachingGroupPerformance: './jsons/adminTeaching.json',
		getResearchGroupPerformance: './jsons/adminResearch.json',

		// some apis for peer review function
		getGroupInfoByUserId: './backend/getgroups.php',
		getKpiInfoByGroupId: './backend/getkpiinfo.php',
		createPeerReviewTable: './backend/getreviewdata.php',
		submitPeerReviewTable: './backend/submitreview.php',

		// get data for adminPeerReviewDetails page
		retriveIndividualDetails: './backend/getradarchartreview.php',
		retriveIndividualKpi: './backend/getgroupreviewforemployeedata.php',
		submitAdminReviewFeedback: './backend/submitadminlevelreview.php',

		// get data for adminPeerReview page
		retriveAdminReviewGroup: './backend/getadminreviewgroups.php',
		retriveAdminReviewGroupData: './backend/adminPeerReview.php',
		createAdminReviewGroup: './backend/createnewgroup.php',
		getAdminReviewGroup: './backend/getgroupsettinginfo.php',
		deleteAdminReviewGroup: './backend/deletegroup.php',
		updateAdminReviewGroup: './backend/updategroup.php',

		// get data for creating new peer review group
		retriveAdminallstaffinfodata: './backend/getallemployeeinfo.php',


		//get data for my reviews
		retriveMyReviewData: './backend/myreview.php',
        
        //HR update profile
        hrUpdateProfile:'./backend/updateemployeeinfo.php',
        //HR delete profile
        hrDeleteProfile:'./backend/deleteemployee.php',
        //HR create profile
        hrCreateProfile:'./backend/register.php'


	})

	.constant('CustIdleTime', {
		idle: 60 * 10,         // seconds
		timeout: 60 * 10,      // seconds
		interval: 60 * 10    // seconds
	})

})();