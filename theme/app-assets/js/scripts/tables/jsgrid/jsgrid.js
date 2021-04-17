/*=========================================================================================
    File Name: jsgrid.js
    Description: jsgrid Datatable.
    ----------------------------------------------------------------------------------------
    Item Name: Stack - Responsive Admin Theme
    Version: 3.0
    Author: Pixinvent
    Author URL: hhttp://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(document).ready(function() {

/****************************
*      Basic Scenario       *
****************************/

$("#basicScenario").jsGrid({
width: "100%",
filtering: true,
editing: true,
inserting: true,
sorting: true,
paging: true,
autoload: true,
pageSize: 15,
pageButtonCount: 5,
deleteConfirm: "Do you really want to delete the client?",
controller: db,
fields: [
    { name: "Name", type: "text", width: 150 },
    { name: "Age", type: "number", width: 50 },
    { name: "Address", type: "text", width: 200 },
    { name: "Country", type: "select", items: db.countries, valueField: "Id", textField: "Name" },
    { name: "Married", type: "checkbox", title: "Is Married", sorting: false },
    { type: "control" }
]
});

/***********************************
*      Data Service Scenario       *
***********************************/

 $("#serviceScenario").jsGrid({
        height: "auto",
        width: "100%",

        sorting: true,
        paging: false,
        autoload: true,

        controller: {
            loadData: function() {
                var d = $.Deferred();

                $.ajax({
                    url: "http://services.odata.org/V3/(S(3mnweai3qldmghnzfshavfok))/OData/OData.svc/Products",
                    dataType: "json"
                }).done(function(response) {
                    d.resolve(response.value);
                });

                return d.promise();
            }
        },

        fields: [
            { name: "Name", type: "text" },
            { name: "Description", type: "textarea", width: 150 },
            { name: "Rating", type: "number", width: 50, align: "center",
                itemTemplate: function(value) {
                    return $("<div>").addClass("rating").append(Array(value + 1).join("&#9733;"));
                }
            },
            { name: "Price", type: "number", width: 50,
                itemTemplate: function(value) {
                    return value.toFixed(2) + "$"; }
            }
        ]
    });

/******************************
*      Sorting Scenario       *
******************************/

$("#sorting-table").jsGrid({
    height:"400px",
    width: "100%",

    autoload: true,
    selecting: false,

    controller: db,

    fields: [
        { name: "Name", type: "text", width: 150 },
        { name: "Age", type: "number", width: 50 },
        { name: "Address", type: "text", width: 200 },
        { name: "Country", type: "select", items: db.countries, valueField: "Id", textField: "Name" },
        { name: "Married", type: "checkbox", title: "Is Married" }
    ]
});


$("#sort").on('click', function() {
    var field = $("#sortingField").val();
    $("#sorting-table").jsGrid("sort", field);
});

/************************
*      Validation       *
************************/

$("#validation").jsGrid({
    width: "100%",
    filtering: true,
    editing: true,
    inserting: true,
    sorting: true,
    paging: true,
    autoload: true,
    pageSize: 15,
    pageButtonCount: 5,
    deleteConfirm: "Do you really want to delete the client?",
    controller: db,
    fields: [
        { name: "Name", type: "text", width: 150, validate: "required" },
        { name: "Age", type: "number", width: 50, validate: { validator: "range", param: [18, 80] } },
        { name: "Address", type: "text", width: 200, validate: { validator: "rangeLength", param: [10, 250] } },
        { name: "Country", type: "select", items: db.countries, valueField: "Id", textField: "Name",
            validate: { message: "Country should be specified", validator: function(value) { return value > 0; } } },
        { name: "Married", type: "checkbox", title: "Is Married", sorting: false },
        { type: "control" }
    ]
});


/*****************************
*      Loading by Page       *
*****************************/

$("#loading").jsGrid({
    width: "100%",

    autoload: true,
    paging: true,
    pageLoading: true,
    pageSize: 15,
    pageIndex: 2,

    controller: {
        loadData: function(filter) {
            var startIndex = (filter.pageIndex - 1) * filter.pageSize;
            return {
                data: db.clients.slice(startIndex, startIndex + filter.pageSize),
                itemsCount: db.clients.length
            };
        }
    },

    fields: [
        { name: "Name", type: "text", width: 150 },
        { name: "Age", type: "number", width: 50 },
        { name: "Address", type: "text", width: 200 },
        { name: "Country", type: "select", items: db.countries, valueField: "Id", textField: "Name" },
        { name: "Married", type: "checkbox", title: "Is Married" }
    ]
});


$("#pager").on("change", function() {
    var page = parseInt($(this).val(), 10);
    $("#loading").jsGrid("openPage", page);
});

/**********************************
*      Custom View Scenario       *
**********************************/

$("#customView").jsGrid({
    width: "100%",

    filtering: true,
    editing: true,
    sorting: true,
    paging: true,
    autoload: true,

    pageSize: 15,
    pageButtonCount: 5,

    controller: db,

    fields: [
        { name: "Name", type: "text", width: 150 },
        { name: "Age", type: "number", width: 50 },
        { name: "Address", type: "text", width: 200 },
        { name: "Country", type: "select", items: db.countries, valueField: "Id", textField: "Name" },
        { name: "Married", type: "checkbox", title: "Is Married", sorting: false },
        { type: "control", modeSwitchButton: false, editButton: false }
    ]
});


$(".config-panel input[type=checkbox]").on("click", function() {
    var $cb = $(this);
    $("#customView").jsGrid("option", $cb.attr("id"), $cb.is(":checked"));
});

/******* CUSTOM ONE **********
*****************************/
var sampData = [
        { "First Name": "Otto Clay", "Middle Name": "Robt Clay", "Last Name": "Wayne", "PAN Card": "123432", "Aadhaar Card": "1234 5678 6789", "Passport Number": "CT354YST" },
        { "First Name": "Connor Johnston", "Middle Name": "Okur Peter", "Last Name": "Clad", "PAN Card": "593432", "Aadhaar Card": "9734 6754 8745", "Passport Number": "HTI54YST" },
        { "First Name": "Lacey Hess", "Middle Name": "Zander", "Last Name": "Zed", "PAN Card": "923432", "Aadhaar Card": "4563 5678 8332", "Passport Number": "JAH7834IL" },
        { "First Name": "Timothy Henson", "Middle Name": "Misk", "Last Name": "Zyan", "PAN Card": "178432", "Aadhaar Card": "2342 5678 1243", "Passport Number": "LAKSJ345" }
    ];

$("#customView1").jsGrid({
    width: "100%",

    filtering: true,
    editing: true,
    sorting: true,
    paging: true,
    autoload: true,

    pageSize: 15,
    pageButtonCount: 5,

    data: sampData,

    fields: [
        { name: "First Name", type: "text", width: 100, validate: "required" },
        { name: "Middle Name", type: "text", width: 100, validate: "required"},
        { name: "Last Name", type: "text", width: 100, validate: "required" },
        { name: "PAN Card", type: "number", width: 100, validate: "required" },
        { name: "Aadhaar Card", type: "number", width: 100, validate: "required" },
        { name: "Passport Number", type: "text", width: 100, validate: "required" },
        { type: "control", modeSwitchButton: true, editButton: true }
    ]
});


$(".config-panel input[type=checkbox]").on("click", function() {
    var $cb = $(this);
    $("#customView1").jsGrid("option", $cb.attr("id"), $cb.is(":checked"));
});
/*#############################################################################*/

var sampData2 = [
        { "Sr": 1, "Name": "Field Agent", "Rule Name": 1, "Description": "Wayne" },
        { "Sr": 2, "Name": "MisExecutive", "Rule Name": 2, "Description": "Clad" },
        { "Sr": 3, "Name": "SysAdmin", "Rule Name": 3, "Description": "Zed" }
    ];

var selectDrop2 = [
        { Name1: " -- Select Rule --", Id: 0 },
        { Name1: "Rule 1", Id: 1 },
        { Name1: "Rule 2", Id: 2 },
        { Name1: "Rule 3", Id: 3 }
    ];

$("#customView2").jsGrid({
    width: "100%",

    filtering: true,
    editing: true,
    sorting: true,
    paging: true,
    autoload: true,

    pageSize: 15,
    pageButtonCount: 5,

    data: sampData2,

    fields: [
        { name: "Sr", type: "text", width: 10, },
        { name: "Name", type: "text", width: 100, validate: "required" },
        { name: "Rule Name", type: "select", width: 100, validate: "required", 
        items: selectDrop2, valueField: "Id", textField: "Name1"},
        { name: "Description", type: "text", width: 100, validate: "required" },
        { type: "control", modeSwitchButton: true, editButton: true }
    ]
});


$(".config-panel input[type=checkbox]").on("click", function() {
    var $cb = $(this);
    $("#customView2").jsGrid("option", $cb.attr("id"), $cb.is(":checked"));
});

/*#############################################################################*/

var sampData3 = [
        { "Sr": 1, "Name": "Authenticated User", "Rule Name": 1, "Description": "Authenticated user Permissions" },
        { "Sr": 2, "Name": "Guest User", "Rule Name": 2, "Description": "Guest User Permissions" },
        { "Sr": 3, "Name": "Test", "Rule Name": 3, "Description": "Test B" }
    ];

var selectDrop3 = [
        { Name2: " -- Select Rule --", Id: 0 },
        { Name2: "Rule 1", Id: 1 },
        { Name2: "Rule 2", Id: 2 },
        { Name2: "Rule 3", Id: 3 }
    ];

$("#customView3").jsGrid({
    width: "100%",

    filtering: true,
    editing: true,
    sorting: true,
    paging: true,
    autoload: true,

    pageSize: 15,
    pageButtonCount: 5,

    data: sampData3,

    fields: [
        { name: "Sr", type: "text", width: 10, },
        { name: "Name", type: "text", width: 100, validate: "required" },
        { name: "Rule Name", type: "select", width: 100, validate: "required", 
        items: selectDrop3, valueField: "Id", textField: "Name2"},
        { name: "Description", type: "text", width: 100, validate: "required" },
        { type: "control", modeSwitchButton: true, editButton: true }
    ]
});


$(".config-panel input[type=checkbox]").on("click", function() {
    var $cb = $(this);
    $("#customView3").jsGrid("option", $cb.attr("id"), $cb.is(":checked"));
});

/*#############################################################################*/

var sampData4 = [
        { "Sr": 1, "User Name": "System Admin", "First Name": "Sys", 
        "Last Name": "Admin", "Roles Assigned": "Admin" },
        { "Sr": 2, "User Name": "Manager", "First Name": "Manager", 
        "Last Name": "lname", "Roles Assigned": "Office Work" },
        { "Sr": 3, "User Name": "Sales", "First Name": "Sales", 
        "Last Name": "myname", "Roles Assigned": "Field" }
    ];

$("#customView4").jsGrid({
    width: "100%",

    filtering: true,
    editing: true,
    sorting: true,
    paging: true,
    autoload: true,

    pageSize: 15,
    pageButtonCount: 5,

    data: sampData4,

    fields: [
        { name: "Sr", type: "text", width: 10, validate: "required" },
        { name: "User Name", type: "text", width: 100, validate: "required"},
        { name: "First Name", type: "text", width: 100, validate: "required" },
        { name: "Last Name", type: "text", width: 100, validate: "required" },
        { name: "Roles Assigned", type: "text", width: 100, validate: "required" },
        { type: "control", modeSwitchButton: true, editButton: true }
    ]
});


$(".config-panel input[type=checkbox]").on("click", function() {
    var $cb = $(this);
    $("#customView4").jsGrid("option", $cb.attr("id"), $cb.is(":checked"));
});

/*#################################################################################*/

/**************************
*      Batch Delete       *
**************************/

$("#batchDelete").jsGrid({
    width: "100%",
    autoload: true,
    confirmDeleting: false,
    paging: true,
    controller: {
        loadData: function() {
            return db.clients;
        }
    },
    fields: [
        {
            headerTemplate: function() {
                return $("<button>").attr("type", "button").text("Delete") .addClass("btn btn-primary mr-1")
                        .on("click", function () {
                            deleteSelectedItems();
                        });
            },
            itemTemplate: function(_, item) {
                return $("<input>").attr("type", "checkbox")
                        .prop("checked", $.inArray(item, selectedItems) > -1)
                        .on("change", function () {
                            $(this).is(":checked") ? selectItem(item) : unselectItem(item);
                        });
            },
            align: "center",
            width: 50
        },
        { name: "Name", type: "text", width: 150 },
        { name: "Age", type: "number", width: 50 },
        { name: "Address", type: "text", width: 200 }
    ]
});


var selectedItems = [];

var selectItem = function(item) {
    selectedItems.push(item);
};

var unselectItem = function(item) {
    selectedItems = $.grep(selectedItems, function(i) {
        return i !== item;
    });
};

var deleteSelectedItems = function() {
    if(!selectedItems.length || !confirm("Are you sure?"))
        return;

    deleteClientsFromDb(selectedItems);

    var $grid = $("#batchDelete");
    $grid.jsGrid("option", "pageIndex", 1);
    $grid.jsGrid("loadData");

    selectedItems = [];
};

var deleteClientsFromDb = function(deletingClients) {
    db.clients = $.map(db.clients, function(client) {
        return ($.inArray(client, deletingClients) > -1) ? null : client;
    });
};

/*************************************
*      External Pager Scenario       *
*************************************/

$("#external").jsGrid({
    width: "100%", 
    paging: true,
    pageSize: 15,
    pageButtonCount: 5,
    pagerContainer: "#externalPager",
    pagerFormat: "current page: {pageIndex} &nbsp;&nbsp; {first} {prev} {pages} {next} {last} &nbsp;&nbsp; total pages: {pageCount}",
    pagePrevText: "<",
    pageNextText: ">",
    pageFirstText: "<<",
    pageLastText: ">>",
    pageNavigatorNextText: "&#8230;",
    pageNavigatorPrevText: "&#8230;",

    data: db.clients,

    fields: [
        { name: "Name", type: "text", width: 150 },
        { name: "Age", type: "number", width: 50 },
        { name: "Address", type: "text", width: 200 },
        { name: "Country", type: "select", items: db.countries, valueField: "Id", textField: "Name" },
        { name: "Married", type: "checkbox", title: "Is Married" }
    ]
});


});
