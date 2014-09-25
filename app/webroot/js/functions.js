//This function is used to trim any string value using javascript.function trimString(str) {    return str.replace(/^\s+/g, '').replace(/\s+$/g, '');}// This function is used for email validationfunction isValid(str) {    var emailFilter = /^.+@.+\..{2,3}$/;    if(!(str.match(emailFilter))) {        return false;    }     else {        return true;    }}// This function checks for illegal characters in the emailfunction isEmailUnwantedChars(emailId) {    var illegalChars = /[\(\)\<\>\,\;\:\\\/\"\[\]\']/    if(emailId.match(illegalChars)) {        return true;    }     else {        return false;    }}// This function is used for Numeric valuesfunction isNumeric(str) {    var numFilter = /^[0-9][0-9]*$/;
    if(!(str.match(numFilter))) {        return false;    }     else {        return true;    }}// This function is used for decimal valuesfunction isDecimal(str) {    var numFilter = /^[0-9.]*$/;    if(!(str.match(numFilter))) {        return false;    }     else {        return true;    }}// This function check for the alphanumeric valuefunction isAlphanumeric(fieldVal) {    var strValidChars = /^[0-9a-zA-Z]+$/;    if(!(fieldVal.match(strValidChars))) {        return false;    }     else {        return true;    }}// This function is used for alphabetsfunction isAlphabet(str) {    var numFilter = /^[a-zA-Z]+$/;
    if(!(str.match(numFilter))) {        return false;    }     else {        return true;    }}function hasSpecialChars(fieldValue) {    var iChars = "^{}<>";    var flag = false;        for(var i = 0; i < fieldValue.length; i++) {        if(iChars.indexOf(fieldValue.charAt(i)) != -1) {            flag = true;            break;        }    }    if(flag) {        return true;    }     else {        return false;    }}function hasSpecialCharaters(fieldValue) {    var iChars = "!@#$%^&*()+=[]\\;,/{}|\"<>";
    var flag = false;    // alert("The Following Characters must be removed:	// !@#$%^&*()+=[]\\;,/{}|\":<> ");
    for(var i = 0; i < fieldValue.length; i++) {        if(iChars.indexOf(fieldValue.charAt(i)) != -1) {            flag = true;            break;        }    }
    if(flag) {        return true;    }     else {        return false;    }}// Check For White Spacefunction hasWhiteSpace(fieldValue) {    var iChars = "\t\n\r ";    var flag = false;        for(var i = 0; i < fieldValue.length; i++) {        if(iChars.indexOf(fieldValue.charAt(i)) != -1) {            flag = true;            break;        }    }
    if(flag) {        return true;    }     else {        return false;    }}// This function check for the valid phone numberfunction isPhone(fieldVal) {    var strValidChars = "0123456789- ()";    var blnResult = true;
    for( i = 0; i < fieldVal.length; i++) {        strChar = fieldVal.charAt(i);
        if(strValidChars.indexOf(strChar) == -1) {            blnResult = false;        }    }
    if(blnResult == false) {        return false;    }     else {        return true;    }}
// This function check for the valid zip codefunction isZipCode(fieldVal) {    var strValidChars = "0123456789";
    var blnResult = true;    var fldLength = fieldVal.length;        if(fldLength == 5) {        for( i = 0; i < fldLength; i++) {            strChar = fieldVal.charAt(i);            if(strValidChars.indexOf(strChar) == -1) {                blnResult = false;            }        }    }     else {        blnResult = false;    }
    if(blnResult == false) {        return false;    }     else {        return true;    }}// This function is used to open a pop up window. User need to pass only two// parameters
// 1) pageURL like: "userDetails.php?id=2"
// 2) windowName: Name of the pop up window
function ShowDetails(pageURL, windowName) {    var nLeft, nTop, nWidth, nHeight;    nWidth = 700;    nHeight = 600;    nLeft = screen.width - nWidth - 50;    nTop = screen.height - nHeight - 100;    Window1 = window.open(pageURL, windowName, "dependent=yes,height=" + nHeight + ",width=" + nWidth + ",left=" + nLeft + ",top=" + nTop + ",location=no,menubar=no,resizable=yes,scrollbars=yes");    Window1.focus();}function ShowDetailsLarge(pageURL, windowName) {     var nLeft, nTop, nWidth, nHeight;           nWidth = 800;    nHeight = 700;    nLeft = screen.width - nWidth - 50;    nTop = screen.height - nHeight - 100;    Window1 = window.open(pageURL, windowName, "dependent=yes,height=" + nHeight + ",width=" + nWidth + ",left=" + nLeft + ",top=" + nTop + ",location=no,menubar=no,resizable=yes,scrollbars=yes");    Window1.focus();}
function ShowDetailssmall(pageURL, windowName) {    var nLeft, nTop, nWidth, nHeight;        nWidth = 500;    nHeight = 400;        nLeft = screen.width - nWidth - 50;    nTop = screen.height - nHeight - 100;    Window1 = window.open(pageURL, windowName, "dependent=yes,height=" + nHeight + ",width=" + nWidth + ",left=" + nLeft + ",top=" + nTop + ",location=no,menubar=no,resizable=yes,scrollbars=yes");    Window1.focus();}// /for commentsfunction ShowcommentsNoBars(pageURL, windowName, nWidth, nHeight) {    Window1 = window.open(pageURL, windowName, "dependent=yes,height=" + nHeight + ",width=" + nWidth + ",location=no,menubar=no,resizable=yes,scrollbars=no");    Window1.focus();}function Showcomments(pageURL, windowName, nWidth, nHeight) {    Window1 = window.open(pageURL, windowName, "dependent=yes,height=" + nHeight + ",width=" + nWidth + ",location=no,menubar=no,resizable=yes,scrollbars=yes");    Window1.focus();}// This function is used to check and uncheck all check box in the listing page// check_all: Name of the button on whose click checkAll() function is called// check_delete[]: Name of the check box against each row
function checkAll() {    var check_all = document.getElementById('check_all').checked;    var getCheckBox = document.getElementsByName('check_delete[]');
    // If Check box is checked, then check all checkbox to delete record    if(check_all) {        for(var i = 0; i < getCheckBox.length; i++) {            getCheckBox[i].checked = true;        }    }     else {        // If Check box is unchecked, then uncheck all checkbox to delete record        for(var i = 0; i < getCheckBox.length; i++) {            getCheckBox[i].checked = false;        }    }}function deleteSelectedAthlete(){	var countChecked = 0;	var checkBox = document.getElementsByName('check_delete[]');	var totalCheckboxes = document.getElementsByName('check_delete[]').length;	if(totalCheckboxes!=0){		for(var i=0; i<totalCheckboxes; i++){			if(checkBox[i].checked == true){				countChecked = countChecked+1;			}		}	}	if(countChecked!=0){		if( confirm("Are you sure to delete the selected Athlete?")) {			document.frmUsers.action="/admin/Athlete/deleteSelected";			document.frmUsers.submit();			return true;		}		return false;	}else{		alert("Please select at least one Athlete to delete");		return false;	}}// ////// function for uncheck the all check checkboxfunction checkItSelf() {    // alert(myId);    // var check_myself = document.getElementById(myId).checked;
    var getCheckBox = document.getElementsByName('check_delete[]');    // If Check box is checked, then check all checkbox to delete record    var chk = 'none';
    for(var i = 0; i < getCheckBox.length; i++) {        if(getCheckBox[i].checked == false) {            chk = 'have';        }    }
    if(chk == 'have') {        document.getElementById('check_all').checked = false;    }     else {        document.getElementById('check_all').checked = true;    }}// Add more fields dynamically.function addField(area, field, limit) {    if(!document.getElementById)        return;    // Prvent older browsers from getting any further.    var field_area = document.getElementById(area);    var all_inputs = field_area.getElementsByTagName("input");
    var last_item = all_inputs.length - 1;    var last = all_inputs[last_item].id;    var count = Number(last.split("_")[1]) + 1;
    if(count > limit && limit > 0)        return;
    field_area.innerHTML += "<li><input name='" + (field + count) + "' id='" + (field + count) + "' type='text' size='26' class='txtFont'/></li>";}function confirmOnDelete() {    if(confirm("Do you really want to delete record")) {        return true;    }    else {        return false;    }}function emailCheck(emailStr) {    var checkTLD = 1;
    var knownDomsPat = /^(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum)$/;
    var emailPat = /^(.+)@(.+)$/;    var specialChars = "\\(\\)><@,;:\\\\\\\"\\.\\[\\]";
    var validChars = "\[^\\s" + specialChars + "\]";    var quotedUser = "(\"[^\"]*\")";    var ipDomainPat = /^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/;    var atom = validChars + '+';    var word = "(" + atom + "|" + quotedUser + ")";
    var userPat = new RegExp("^" + word + "(\\." + word + ")*$");    var domainPat = new RegExp("^" + atom + "(\\." + atom + ")*$");    var matchArray = emailStr.match(emailPat);    if(matchArray == null) {        return false;    }
    var user = matchArray[1];
    var domain = matchArray[2];    for( i = 0; i < user.length; i++) {        if(user.charCodeAt(i) > 127) {            return false;        }    }
    for( i = 0; i < domain.length; i++) {        if(domain.charCodeAt(i) > 127) {            return false;        }    }
    // See if "user" is valid    if(user.match(userPat) == null) {        return false;    }    var IPArray = domain.match(ipDomainPat);    if(IPArray != null) {
        for(var i = 1; i <= 4; i++) {            if(IPArray[i] > 255) {                return false;            }        }                return true;    }
    var atomPat = new RegExp("^" + atom + "$");    var domArr = domain.split(".");    var len = domArr.length;    for( i = 0; i < len; i++) {        if(domArr[i].search(atomPat) == -1) {            return false;        }    }    if(checkTLD && domArr[domArr.length - 1].length != 2 && domArr[domArr.length - 1].search(knownDomsPat) == -1) {        return false;    }
    if(len < 2) {        return false;    }
    return true;}function isURL(urlStr) {    var checkTLD = 1;
    var knownDomsPat = /^(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum)$/;    if(urlStr.indexOf(" ") != -1) {        return false;    }
    if(urlStr == "" || urlStr == null) {        return true;    }        urlStr = urlStr.toLowerCase();
    var specialChars = "\\(\\)><@,;:\\\\\\\"\\.\\[\\]";
    var validChars = "\[^\\s" + specialChars + "\]";    var atom = validChars + '+';
    var urlPat = /^(\w*)\.([\-\+a-z0-9]*)\.(\w*)/;
    var matchArray = urlStr.match(urlPat);
    if(matchArray == null) {        return false;    }
    var user = matchArray[2];
    var domain = matchArray[3];    for( i = 0; i < user.length; i++) {        if(user.charCodeAt(i) > 127) {            return false;        }    }
    for( i = 0; i < domain.length; i++) {        if(domain.charCodeAt(i) > 127) {            return false;        }    }
    var atomPat = new RegExp("^" + atom + "$");
    var domArr = domain.split(".");
    var len = domArr.length;
    for( i = 0; i < len; i++) {        if(domArr[i].search(atomPat) == -1) {            return false;        }    }    if(checkTLD && domArr[domArr.length - 1].length != 2 && domArr[domArr.length - 1].search(knownDomsPat) == -1) {        return false;    }
    return true;}