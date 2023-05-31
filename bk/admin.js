//Testing Data
var TestingData_date = ["2023-03-27", "2023-03-28"];
var TestingData_location = ["Hong Kong", "Japan"];
var TestingData_species = ["White Bird", "Red Bird"];
var TestingData_quantity = ["Single", "Pair"];

var stateData = [];
var table = document.getElementById("submitApply");
let htmlString = "";

//Button function
function approve(id) {
    document.getElementById("state_"+id).innerHTML = "Approved";
}

function reject(id) {
    document.getElementById("state_"+id).innerText = "Rejected";
}

function submitDataToDB() {
    for (var i = 0; i < TestingData_date.length; i++) {
        stateData.push(document.getElementById('state_'+i).innerHTML);
    }
    document.getElementById("result").innerHTML = stateData;
}

//Loop to read data and generate a table form.
for (var i = 0; i < TestingData_date.length; i++) {
    htmlString += '<tr><td>'+TestingData_date[i]+'</td><td>'+TestingData_location[i]+'</td><td>'+TestingData_species[i]+'</td><td>'+TestingData_quantity[i]+'</td>';
    htmlString += '<td><button id = '+i+' onclick = approve(this.id)>Approve</button></td><td><button id = '+i+' onclick = reject(this.id)>Reject</button></td>';
    htmlString += '<td id = state_'+i+'>Pending</td></tr>';
}
table.innerHTML = htmlString;

