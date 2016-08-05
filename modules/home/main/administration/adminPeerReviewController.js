/**
 * Created by chengchengding on 1/05/15.
   contributed by Xiao Zhang
 */
angular.module('adminPeerReview')
    .controller('adminPeerReviewController', ['$scope','adminReviewTableProvider','$timeout','$cookieStore',function($scope,adminReviewTableProvider,$timeout,$cookieStore){
        var user = $cookieStore.get('globals');

        adminReviewTableProvider.getAllReviewGroups()
            .then(function(response) {
                if (response.state) {
                    $scope.myGroups = response.data;
                    $scope.myGroups[0].active = true;
                    ////console.log($scope.myGroups[0])
                    load($scope.myGroups[0].groupid);
                }
            },
            function(response) {
                //console.log(response);
            });

        var graphData = $scope.graphData={"cols":[],"rows":[]}

        var load = function(groupId) {
            //console.log(groupId)
            $scope.currentGroup=groupId
            adminReviewTableProvider.getReviewGroupData(groupId)
                .then(function(response) {
                    //initialise data for table
                    $scope.myTableTitle = response.titles;
                    $scope.myTableData = response.data;
                    $scope.displayedCollection = [].concat($scope.myTableData);
                    //console.log($scope.myTableData)

                    //initialise JSON for chart
                    graphData.cols=[]
                    graphData.rows=[]
                    graphData.cols.push({
                        "label": "Staff",
                        "type": "string"
                    })
                    //graphData.rows.push()
                    //initialise cols
                    for (var i=0; i<$scope.myTableTitle.length; i++){
                        graphData.cols.push({
                            "label":$scope.myTableTitle[i].performancetypename,
                            "type":"number"
                        })
                    }
                    //initialise rows
                    for (var i=0; i<$scope.myTableData.length; i++){
                        var c = [{
                            "v":$scope.myTableData[i].empname
                        }]
                        for (var j=0; j<$scope.myTableData[i].columns.length; j++){
                            c.push({
                                "v": $scope.myTableData[i].columns[j].avgValue
                            })
                        }
                        graphData.rows.push({
                            "c":c
                        })
                    }
                },
                function(response) {
                    //console.log(response);
                });
        }

        $scope.reload = function(groupId) {
            currentKpi = 0;
            load(groupId);
        }

        $scope.saveFeedback=function(){
            //console.log($scope.currentRow.empname,$scope.currentCol.kpi_id,$scope.currentCol.avgValue)
            //console.log("feedback: "+$scope.popover.feedback)
            //clear the temp feedback in popover to
            $scope.popover.feedback=""
        }
        $scope.setIndexPath=function(row, column){
            $scope.currentRow=row;
            $scope.currentCol=column;
            $scope.popover.feedback=column.feedback;
        }

        $scope.submit = function(){
            //console.log("submit")
        }

        //popover
        $scope.popover = {
            "content": 'Please add feedback of this KPI for this staff here.',
            "feedback": ""
        };


        $scope.chartObject = {
            "type": "BarChart",
            "displayed": true,
            "data": graphData,
            "options": {
                //"title": "Staff Performance in Programmer Group",
                "isStacked": "true",
                "fill": 50,
                //lineWidth: 50,
                "displayExactValues": true,
                //"height":500,
                //"width":'100%',
                "vAxis": {
                    //"title": "Sales unit",
                    "gridlines": {
                        "count": 10
                    }
                },
                "hAxis": {
                    //"title": "Date"
                },
                "tooltip": {
                    "isHtml": false
                },
                colors: ['#F7A5A7', '#FEB55F','#CCDDE6' , '#EEEEEE', '#f6c7b6']
            },
            "formatters": {}
        }

        $scope.isEdit = false
        $scope.setEdit = function(bool){
            $scope.isEdit = bool
            //console.log($scope.isEdit)
        }
    }])


    .controller("addReviewGroupModalCtrl", ['$scope', 'HTTPConnect', 'appConnectionService',
        'adminReviewService','$state',function($scope, HTTPConnect, appConnectionService,
            adminReviewService,$state){
        //duallist box
            $scope.list = [];
        var length = $scope.list.length;
        adminReviewService.getAllemployeeinfo(
            ).then(function(response){
               $scope.response = response;
               length = response.Data.length;
               
               updateList($scope.response, length);
            },
            function(response){
                //console.log(response);
            })
        
        
        var updateList = function(response, length) {
            for (var i = $scope.list.length; i < length; i++) {
                $scope.list.push({
                    'id':  response.Data[i].empid,
                    'text': response.Data[i].firstname + response.Data[i].lastname + '-' 
                    + response.Data[i].department,
                    'position':response.Data[i].position
                });
            }
        };


        $scope.reset = function() {
             $scope.model = [];
        };


        $scope.settings = {
            bootstrap2: true,
            filterClear: 'Show all!',
            filterPlaceHolder: 'Filter!',
            moveSelectedLabel: 'Move selected only',
            moveAllLabel: 'Move all!',
            removeSelectedLabel: 'Remove selected only',
            removeAllLabel: 'Remove all!',
            moveOnSelect: false,
            preserveSelection: 'moved',
            selectedListLabel: 'Selected Staff',
            nonSelectedListLabel: 'All Staff',
            postfix: '_helperz',
            selectMinHeight: 130,
            filter: true,
            filterNonSelected: '1',
            filterSelected: '4',
            infoAll: 'Showing all {0}!',
            infoFiltered: '<span class="label label-warning">Filtered</span> {0} from {1}!',
            infoEmpty: 'Empty dcc!',
            filterValues: false
        };

            //adding deleting rows for kpis
            $scope.kpiCount = 1
            $scope.addRowItem=function(){
                var newKpi =
                    {
                        "performancedatatype":"review",
                        "performancedescription":"",
                        "performancetypename":""
                    }
                $scope.kpis.push(newKpi)
                $scope.kpiCount++
            }
            $scope.deleteRowItem=function(index){
                $scope.kpis.splice(index,1)
                $scope.kpiCount--
            }

            $scope.saveGroup = function(){
                if ($scope.$parent.isEdit == true){
                    editGroup()
                }else{
                    createGroup()
                }
            }

            //creating group
            $scope.kpis=[
                    {
                        "performancedatatype":"review",
                        "performancedescription":"",
                        "performancetypename":""
                    }
            ]
            var createGroup = function() {
                var fromDate = $scope.fromDate
                var untilDate = $scope.untilDate
                var groupInfo = {
                    "grouptittle": $scope.groupName,
                    "groupstartdate": fromDate,
                    "groupenddate": untilDate,
                    "grouptype": "review"
                }

                var seletedStaff = $scope.model
                //console.log(seletedStaff)
                //console.log($scope.kpis)

                var groupPackage = {"groupinfoData": groupInfo, "employeeData": seletedStaff, "KPIData": $scope.kpis}
                //console.log(groupPackage)
                adminReviewService.createReviewGroup(groupPackage)
                    .then(function(response) {
                        //console.log(response);
                    },
                    function(response) {
                        $state.reload();
                    });
            }
            

            //read group settings
            var readSetting = function(){
                //console.log("currentgroup: "+$scope.$parent.currentGroup)
                adminReviewService.getReviewGroup($scope.$parent.currentGroup)
                    .then(function(response) {
                        if (response.state) {
                            //console.log(response);
                            $scope.groupName = response.groupinfoData.grouptittle;
                            $scope.kpis = response.KPIData
                            for (var i=0; i<response.KPIData.length; i++){
                                //var o = jQuery.extend({}, $scope.kpis[i])
                                var o =  response.KPIData[i]
                                oldKpiArray.push(o)
                            }
                            $scope.kpiCount = $scope.kpis.length
                            var selectedStaff =[]
                            for (var i=0; i<response.employeeData.length; i++){
                                selectedStaff.push(response.employeeData[i].empid)
                            }
                            $scope.model = selectedStaff
                            oldStaffArray = selectedStaff
                            $scope.groupid=response.groupinfoData.groupid
                            $scope.fromDate = response.groupinfoData.groupstartdate
                            $scope.untilDate = response.groupinfoData.groupenddate
                        }
                    },
                    function(response) {
                        //console.log(response);
                    });
            }
            if ($scope.$parent.isEdit){
                readSetting()
            }
            
            //edit group
            var oldStaffArray =[]
            var oldKpiArray =[]
            var editGroup = function() {
                var deletedStaff = []
                var addedStaff = []
                var newStaffArray = $scope.model
                for (var i=0; i<oldStaffArray.length; i++){
                    if (newStaffArray.indexOf(oldStaffArray[i])==-1){
                        deletedStaff.push(oldStaffArray[i])
                    }
                }
                for (var i=0; i<newStaffArray.length; i++){
                    if (oldStaffArray.indexOf(newStaffArray[i])==-1){
                        addedStaff.push(newStaffArray[i])
                    }
                }
                //console.log("deletedstaff,addedstaff: "+deletedStaff,addedStaff)

                var deletedKpi = []
                var addedKpi = []
                var updateKpi = []
                //var newKpiArray = []
                var newKpiArray = $scope.kpis
 
                for (var i=0; i<oldKpiArray.length; i++){

                    if (newKpiArray.indexOf(oldKpiArray[i])==-1){
                        deletedKpi.push(oldKpiArray[i])
                    }
                }
                for (var i=0; i<newKpiArray.length; i++){

                    if (oldKpiArray.indexOf(newKpiArray[i])==-1){
                        addedKpi.push(newKpiArray[i])
                    }else{
                        updateKpi.push(newKpiArray[i])
                    }
                }

                
                var fromDate = $scope.fromDate
                var untilDate = $scope.untilDate
                var groupInfo = {
                    "groupid":$scope.groupid,
                    "grouptittle": $scope.groupName,
                    "groupstartdate": fromDate,
                    "groupenddate": untilDate,
                    "grouptype": "review"
                }
                var groupPackage = {"groupInfo": groupInfo, "deleteEmployee": deletedStaff, "addEmployee": addedStaff, "deletKPI": deletedKpi, "addKPIArray":addedKpi, "updateKPI":updateKpi }
                //console.log(groupPackage)
                adminReviewService.updateReviewGroup(groupPackage)
                    .then(function(response) {
                        //console.log(response);
                    },
                    function(response) {
                        //console.log(response);
                        $window.location.reload();
                });
            }
            
            
            //delete group
            $scope.deleteGroup = function(){
                //console.log("deleteing group"+$scope.groupid);
                 adminReviewService.deleteReviewGroup($scope.groupid)
                    .then(function(response) {
                        //console.log(response);
                    },
                    function(response) {
                        $state.reload();
                    });
            }
    }])


