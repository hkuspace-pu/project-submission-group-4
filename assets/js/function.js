(function($) {
var photosJSON = {};
var photoJSON = {};
var _paramsResult = getUrlParameter();
var pid = _paramsResult["pid"];
var birdid = _paramsResult["birdid"] || 0;
var locationcode = _paramsResult["locationcode"] || 0;
var type = _paramsResult["type"] || 0;

//init();

function initLogin(){
    checkLogin(member_username);
    $(".floating_back_button").click(function(){ floating_back_buttonClick(); return false; });
    clearContent();
}
window.initLogin = initLogin;

function init(){

    if(pid != undefined){
        showPhoto();
    }else{
        showPhotos(photosJSON);
    }
}

function floating_back_buttonClick(){
    showPhotos(photosJSON);
}

function checkLogin(__loginID = ""){
    //console.log(__loginID);
    $("#nav").css('opacity', '1');
    if(__loginID.length == 0){
        $(".after_login_button").remove();
    }else{
        $(".before_login_button").remove();
        $(".after_login_username").html("User: "+__loginID);
    }
}

function clearContent(){
    $(".floating_back_button").hide();
    $(".features_top_view").hide();
    $(".row.aln-center.photo-today").empty();
    $(".main_top_view").hide();
    $(".container.post.photo").empty();
}

function loadJson(__url = ""){
    if(__url == "")return;
    console.log("birdid:"+birdid);
    console.log("locationcode:"+locationcode);
    $(".mainTitle").empty();
    var _jsonTemp;

    if(birdid > 0){
        $.each(infoJsonData.bird_data, function(index, item) {
            if(item.birdID == birdid){
                _jsonTemp = item;
            }
        });

        var $newdiv = $( "<div id=\"content\"><article class=\"box post\" style=\"text-align: left;font-size: 24px;\"><div style=\"display: flex;justify-content: center;align-items: center;\"><img style=\"width:auto !important;\" class=\"pimage\" src=\"\" alt=\"\" /></div><br><h4><span class=\"pname\"></span></h4><span class=\"pdescription\"></span><br><span class=\"phabit\"></span><br></article></div>");
        var _name = _jsonTemp.name;
        var _birdID = _jsonTemp.birdID;
        var _description = _jsonTemp.description;
        var _habit = _jsonTemp.habit;
        var _thumbnail = "/php/uploads/bird/bird"+_birdID+".png";

        $newdiv.find(".pname").append(_name);
        $newdiv.find(".pdescription").append("Description: "+_description);
        $newdiv.find(".phabit").append("Habit: "+_habit);
        $newdiv.find(".pimage").attr('src', _thumbnail);
        $newdiv.find(".pimage").prop('alt', _name);
        $(".mainTitle").append($newdiv);
    }else if(locationcode > 0){

        $.each(infoJsonData.location_data, function(index, item) {
            if(item.locationCode == locationcode){
                _jsonTemp = item;
            }
        });

        var $newdiv = $( "<div id=\"content\"><article class=\"box post\"><br><h4><span class=\"pname\"></span></h4></article></div>");
        var _name = _jsonTemp.locationArea;

        $newdiv.find(".pname").append(_name);
        $(".mainTitle").append($newdiv);
    }else{
        $(".mainTitle").html("Photo of today");
    }
    
    $.getJSON(__url, function(data){
        photosJSON = data.photosJson;
        photoJSON = data.photoJson;
        init();
    }).fail(function(){
        console.log("An error has occurred.");
    });
}
window.loadJson = loadJson;

function listsBird(){
    $.each(infoJsonData.bird_data, function(index, item) {
        var _jsonTemp = item;
        var $newdiv = $( "<div class=\"col-4 col-6-medium col-12-small\"><a href=\"#\" class=\"image featured\"><section  style=\"display: flex;justify-content: center;align-items: center;\"><img style=\"width:auto !important;\" class=\"pimage\" src=\"\" alt=\"\" /><header><h3 class=\"pname\"></h3></header></section></a></div>");
        var _name = _jsonTemp.name;
        var _birdID = _jsonTemp.birdID;
        var _thumbnail = "/php/uploads/bird/bird"+_birdID+"s.png";

        $newdiv.find(".image.featured").attr("href", "index.php?birdid="+_birdID);
        $newdiv.find(".pname").append(_name);
        $newdiv.find(".pimage").attr('src', _thumbnail);
        $newdiv.find(".pimage").prop('alt', _name);
        $(".row.aln-center.photo-today").append($newdiv);
    });

    $(".features_top_view").show();
}
window.listsBird = listsBird;

function listsLocation(){
    $.each(infoJsonData.location_data, function(index, item) {
        var _jsonTemp = item;
        var $newdiv = $( "<div class=\"col-4 col-6-medium col-12-small\"><a href=\"#\" class=\"image featured\"><section  style=\"display: flex;justify-content: center;align-items: center;\"><header><h3 class=\"pname\"></h3></header></section></a></div>");
        var _name = _jsonTemp.locationArea;
        var _locationCode = _jsonTemp.locationCode;

        $newdiv.find(".image.featured").attr("href", "index.php?locationcode="+_locationCode);
        $newdiv.find(".pname").append(_name);
        $(".row.aln-center.photo-today").append($newdiv);
    });

    $(".features_top_view").show();
}
window.listsLocation = listsLocation;

function photoThumbnailClick($this){
    var _paramsResult = getUrlParameter($this.attr('href'));
    window.history.pushState('page2', 'Title', $this.attr('href'));
    pid = _paramsResult["pid"];
    showPhoto();
}

function jumpToPhoto(){
    $('html, body').animate({scrollTop: $(".main_top_view").offset().top}, 0);
}

function showPhoto(){
    clearContent();
    var _jsonTemp;
    
    if (_jsonTemp == null) {
        for(var i = 0;i<photoJSON.length;i++){
            if(photoJSON[i].pid == pid){
                _jsonTemp = photoJSON[i];
                break;
            }
        }
    }

    if (_jsonTemp == null) {
        for(var i = 0;i<photosJSON.length;i++){
            if(photosJSON[i].pid == pid){
                _jsonTemp = photosJSON[i];
                break;
            }
        }
    }



    if(_jsonTemp.length != 0){

        var $newdiv = $( "<div id=\"content\"><article class=\"box post\"><header><h2 class=\"ptitle\"></h2></header><span class=\"image featured\"><img class=\"pimage\" src=\"\" alt=\"\" /></span><h4><span class=\"pname\"></span></h4><h4><span class=\"pdate\"></span></h4><h4><a href=\"#\" class=\"pbird_click\"><span class=\"pbird_type\" style=\"text-decoration: underline;\"></span></a><br><span class=\"pnumberOfBirds\"></span><br><a href=\"#\" class=\"plocation_click\"><span class=\"plocation\" style=\"text-decoration: underline;\"></span></a><br><span class=\"pip_address\"></span><br></h4><br><p><span class=\"pcontent\"></span></p></article></div>");

        var _name = _jsonTemp.name;
        var _pid = _jsonTemp.pid;
        var _date = _jsonTemp.date;
        var _title = _jsonTemp.title;
        var _location = _jsonTemp.location;
        var _picture = _jsonTemp.picture[0];
        var _content = _jsonTemp.content;
        var _bird_type = _jsonTemp.bird_type;
        var _locationID = _jsonTemp.locationID;
        var _birdID = _jsonTemp.birdID;
        var _pip_address = _jsonTemp.IP_address;
        var _numberOfBirds = _jsonTemp.numberOfBirds;

        
        $newdiv.find(".pbird_click").attr("href", "index.php?birdid="+_birdID);
        $newdiv.find(".plocation_click").attr("href", "index.php?locationcode="+_locationID);

        $newdiv.find(".pip_address").append("ip: "+_pip_address);
        $newdiv.find(".pbird_type").append("Species: "+_bird_type);
        $newdiv.find(".pname").append(_name);
        $newdiv.find(".pdate").append("Date: "+_date);
        $newdiv.find(".ptitle").append(_title);
        $newdiv.find(".plocation").append("Location: "+_location);
        $newdiv.find(".pnumberOfBirds").append("Quantity: "+_numberOfBirds);
        $newdiv.find(".pcontent").append(_content);
        $newdiv.find(".pimage").attr('src', _picture);
        $newdiv.find(".pimage").prop('alt', _title);
        $(".container.post.photo").append($newdiv);
    }
    $(".floating_back_button").show();
    $(".main_top_view").show();
    jumpToPhoto();
}

function showPhotos(__json){
    clearContent();
    for(var i = 0;i<__json.length;i++){
        var _jsonTemp = __json[i];
        var $newdiv = $( "<div class=\"col-4 col-6-medium col-12-small\"><a href=\"#\" class=\"image featured\"><section><img class=\"pimage\" src=\"\" alt=\"\" /><header><h3 class=\"ptitle\"></h3></header><p><span class=\"pdate\"></span><br><span class=\"pname\"></span><br><span class=\"pbird_type\"></span><br><span class=\"plocation\"></span></p></section></a></div>");
        var _name = _jsonTemp.name;
        var _pid = _jsonTemp.pid;
        var _date = _jsonTemp.date;
        var _title = _jsonTemp.title;
        var _bird_type = _jsonTemp.bird_type;
        var _pip_address = _jsonTemp.IP_address;
        var _location = _jsonTemp.location;
        var _thumbnail = _jsonTemp.thumbnail;
        var url = window.location.href.split('?')[0];
        url = url.split('#')[0];
        $newdiv.find(".image.featured").click(function(){ photoThumbnailClick($(this)); return false; });
        $newdiv.find(".image.featured").attr("href", url +"?pid="+_pid +"&birdid="+birdid +"&locationcode="+locationcode);

        $newdiv.find(".pname").append(_name);
        $newdiv.find(".pdate").append(_date);
        $newdiv.find(".ptitle").append(_title);
        $newdiv.find(".plocation").append(_location);
        $newdiv.find(".pbird_type").append(_bird_type);
        $newdiv.find(".pimage").attr('src', _thumbnail);
        $newdiv.find(".pimage").prop('alt', _title);
        $(".row.aln-center.photo-today").append($newdiv);
    }
    $(".features_top_view").show();
}

function getUrlParameter(_path = "") {
    var url = (_path.length == 0)?window.location.toString():_path;
    url = url.split('#')[0];
    var qs = url.substring(url.indexOf('?') + 1).split('&');
    for(var i = 0, result = {}; i < qs.length; i++){
        qs[i] = qs[i].split('=');
        result[qs[i][0]] = decodeURIComponent(qs[i][1]);
    }
    return result;
}

$('#login_submit').click(function(event) {
    event.preventDefault();

    var username = $('#login_username').val();
    var password = $('#login_password').val();

    $('#loginFail').html("");

    if (!checkusername(username)) {
        displayError($('#loginFail'),"usernameInsertError");
        //alert("使用者名稱必須為 8 到 16 個字符，只能包含字母、數字和底線");
        return;
    }
    if (!checkPassword(password)) {
        displayError($('#loginFail'),"passwordInsertError")
        //alert("密碼必須為 8 到 16 個字符，只能包含字母、數字和底線");
        return;
    }

    var formData = {
        username: username,
        password: password
    };

    $.ajax({
        type: 'POST',
        url: 'php/login.php',
        data: JSON.stringify(formData),
        contentType: 'application/json',
        success: function(response) {
            console.log(response);
            if(response.status == 1){
                window.location.href = "index.php";
            }else if(response.status == 2){
                displayError($('#loginFail'),response.error);
            }
        },
        error: function(error) {
            console.log(error);
        }
    });
});

$('#register_submit').click(function(event) {
    event.preventDefault();

    var firstname = $('#register_firstname').val();
    var lastname = $('#register_lastname').val();
    var email = $('#register_email').val();
    var confirm_email = $('#register_confirm_email').val();
    var username = $('#register_username').val();
    var password = $('#register_password').val();
    var confirm_password = $('#register_confirm_password').val();
    $('#register_firstname').val(setStringFormat(firstname));
    $('#register_lastname').val(setStringFormat(lastname));
    $('#register_email').val(email.toLowerCase());
    
    $('#registerFail').html("");

    if (firstname.length == 0) {
        displayError($('#registerFail'),"firstnameInsertError");
        return;
    }
    if (lastname.length == 0) {
        displayError($('#registerFail'),"lastnameInsertError");
        return;
    }
    if (!checkEmail(email)) {
        displayError($('#registerFail'),"emailInsertError");
        return;
    }
    if (email != confirm_email) {
        displayError($('#registerFail'),"confirmEmailInsertError");
        return;
    }
    if (!checkusername(username)) {
        displayError($('#registerFail'),"usernameInsertError");
        return;
    }
    if (!checkPassword(password)) {
        displayError($('#registerFail'),"passwordInsertError")
        return;
    }
    if (password != confirm_password) {
        displayError($('#registerFail'),"confirmPasswordInsertError");
        return;
    }

    var formData = {
        firstname: firstname,
        lastname: lastname,
        email: email,
        username: username,
        password: password
    };

    $.ajax({
        type: 'POST',
        url: 'php/register.php',
        data: JSON.stringify(formData),
        contentType: 'application/json',
        success: function(response) {
            console.log(response);
            if(response.status == 1){
                window.location.href = "login.php";
            }else if(response.status == 2){
                displayError($('#registerFail'),response.error);
            }
        },
        error: function(error) {
            console.log(error);
        }
    });
});

$('#survey-add-photo-button').click(function(event) {
    event.preventDefault();
    if (uploadRowCount >= 3)return;
    var uploadRow = '<div class="survey-upload-row" style="padding:3px;"><input type="file" name="photo[]" class="survey-upload-input"><button class="survey-delete-button">Delete</button></div>';
    $('#survey-upload-container').append(uploadRow);

    var uploadRowCount = $('.survey-upload-row').length;
    if (uploadRowCount >= 3) {
        $('#survey-add-photo-button').prop('disabled', true);
      } else {
        $('#survey-add-photo-button').prop('disabled', false);
      }
});

// Delete Photo Button
$('#survey-upload-container').on('click', '.survey-delete-button', function(event) {
    event.preventDefault();
    $(this).parent('.survey-upload-row').remove();
    $('#survey-add-photo-button').prop('disabled', false);
});


function processUploadedPhotos() {
    var uploadRowCount = $('.survey-upload-row').length;
    var photoBase64 = new Array();
    if (uploadRowCount <= 3) {
        var photoInputs = $('.survey-upload-row').find('.survey-upload-input');

        photoInputs.each(function(index, input) {
            var file = input.files[0];
            if (file) {
                var reader = new FileReader();
                //photoBase64.push("test");

                reader.onload = function(event) {
                    var base64 = event.target.result;
                    //console.log(uploadRowCount+"::"+index);
                    //var _data = event.target.result.split(',')[1];
                    photoBase64.push(base64);
                    //console.log(event.target.result);
                    //console.log(event.target.result.split(',')[1]);
                    //addPhotoData(base64);
                    //console.log(photoBase64.length);
                    // Check if all photos are processed
                    //if (photoBase64.length === uploadRowCount) {
                    // Perform further actions with photoBase64 array
                    //console.log(photoBase64);
                    //}
                    submitSurveyForm(photoInputs,photoBase64);
                };

                reader.readAsDataURL(file);
            }else{
                displayError($('#surveyFail'),"photoInsertError");
            }
        });
    }

    return photoBase64;
}

function generateSurveyFormInfo(){
    $.each(infoJsonData.location_data, function(index, item) {
        $('#survey_location').append($('<option>', {
          value: item.locationCode,
          text: item.locationArea
        }));
    });

    $.each(infoJsonData.bird_data, function(index, item) {
        $('#survey_bird').append($('<option>', {
          value: item.birdID,
          text: item.name
        }));
    });

    $.each(infoJsonData.numOfBirds_data, function(index, item) {
        $('#survey_numberOfBirds').append($('<option>', {
          value: item.numberOfBirdsID,
          text: item.description
        }));
    });
}

var survey_title = "";
var survey_description = "";
var survey_date = "";
var survey_location = "";
var survey_bird = "";
var survey_numberOfBirds = "";

window.generateSurveyFormInfo = generateSurveyFormInfo;

$('#survey_submit').click(function(event) {
    event.preventDefault();

    var currentDate = new Date();

    survey_title = $('#survey_title').val();
    survey_description = $('#survey_description').val();
    var survey_form_date = $('#survey_date').val();
    survey_location =  $('#survey_location').val();
    survey_bird =  $('#survey_bird').val();
    survey_numberOfBirds =  $('#survey_numberOfBirds').val();

    $('#surveyFail').html("");

    if (survey_form_date.length == 0) {
        displayError($('#surveyFail'),"survey_dateInsertError");
        return;
    }

    var dateComponents = survey_form_date.split('-');
    var sYear = dateComponents[0];
    var sMonth = dateComponents[1];
    sMonth = sMonth.toString().padStart(2, "0");
    var sDay = dateComponents[2];
    sDay = sDay.toString().padStart(2, "0");
    var s_date = sYear + sMonth + sDay;
    var s_date_num = parseInt(s_date);
    survey_date = sYear + "/" + sMonth + "/" + sDay;

    var cYear = currentDate.getFullYear();
    var cMonth = currentDate.getMonth() + 1;
    cMonth = cMonth.toString().padStart(2, "0");
    var cDay = currentDate.getDate();
    cDay = cDay.toString().padStart(2, "0");
    var c_date = cYear + cMonth + cDay;
    var c_date_num = parseInt(c_date);


    if(s_date_num > c_date_num){
        displayError($('#surveyFail'),"survey_dateInsertError");
        return;
    }

    if (survey_location == "0" || survey_location == "" || survey_location == null) {
        displayError($('#surveyFail'),"survey_locationInsertError");
        return;
    }

    if (survey_bird == "0" || survey_bird == "" || survey_bird == null) {
        displayError($('#surveyFail'),"survey_birdInsertError");
        return;
    }

    if (survey_numberOfBirds == "0" || survey_numberOfBirds == "" || survey_numberOfBirds == null) {
        displayError($('#surveyFail'),"survey_numberOfBirdsInsertError");
        return;
    }

    if (survey_title.length == 0) {
        displayError($('#surveyFail'),"titleInsertError");
        return;
    }
    if (survey_description.length == 0) {
        displayError($('#surveyFail'),"descriptionInsertError");
        return;
    }

    processUploadedPhotos();
});

function submitSurveyForm(_total,photoBase64){
console.log(_total+":::"+photoBase64.length);
    if(_total > photoBase64.length)return
    
    var formData = {
        title: survey_title,
        description: survey_description,
        survey_date: survey_date,
        survey_location: survey_location,
        survey_numberOfBirds: survey_numberOfBirds,
        survey_bird: survey_bird,
        photoBase64: photoBase64
    };

    $.ajax({
        type: 'POST',
        url: 'php/surveyform.php',
        data: JSON.stringify(formData),
        contentType: 'application/json',
        success: function(response) {
            console.log(response);
            if(response.status == 1){
                var pid = response.insertedID;
                window.location.href = "index.php?pid"+pid;
            }else if(response.status == 2){
                displayError($('#registerFail'),response.error);
            }
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function setStringFormat(__inputString){
    var words = __inputString.toLowerCase().split(" ");
    var formattedString = "";

    for (var i = 0; i < words.length; i++) {
        var word = words[i];
        var formattedWord = word.charAt(0).toUpperCase() + word.slice(1);
        formattedString += formattedWord + " ";
    }

    formattedString = formattedString.trim();

    return formattedString;
}

function checkusername(__username){
    var regex = /^[a-zA-Z0-9_]{8,16}$/;
    return regex.test(__username);
}

function checkPassword(__password){
    var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=<>?]).{8,24}$/;
    return regex.test(__password);
}

function checkEmail(__email){
    var regex = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;
    return regex.test(__email);
}

function displayError(__id, __msgId){
    __id.html(__msgId);
}

function makeid(length) {
    let result = '';
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    const charactersLength = characters.length;
    let counter = 0;
    while (counter < length) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
      counter += 1;
    }
    return result;
}

})(jQuery);