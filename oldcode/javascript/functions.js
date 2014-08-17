//This function is used to trim any string value using javascript.
function trimString(str) {
    return str.replace(/^\s+/g, '').replace(/\s+$/g, '');
}//This function is used for email validation
function isValid(str) {
    var emailFilter = /^.+@.+\..{2,3}$/;
    if(!(str.match(emailFilter))) {
        return false;
    } else {
        return true;
    }
}//This function checks for illegal characters in the email
function isEmailUnwantedChars(emailId) {
    var illegalChars = /[\(\)\<\>\,\;\:\\\/\"\[\]\']/
    if(emailId.match(illegalChars)) {
        return true;
    } else {
        return false;
    }
}//This function is used for Numeric values
function isNumeric(str) {
    var numFilter = /^[0-9][0-9]*$/;
    if(!(str.match(numFilter))) {
        return false;
    } else {
        return true;
    }
}//This function is used for decimal values
function isDecimal(str) {
    var numFilter = /^[0-9.]*$/;
    if(!(str.match(numFilter))) {
        return false;
    } else {
        return true;
    }
}// This function check for the alphanumeric value
function isAlphanumeric(fieldVal) {
    var strValidChars = /^[0-9a-zA-Z]+$/;
    if(!(fieldVal.match(strValidChars))) {
        return false;
    } else {
        return true;
    }
}//This function is used for alphabets
function isAlphabet(str) {
    var numFilter = /^[a-zA-Z]+$/;
    if(!(str.match(numFilter))) {
        return false;
    } else {
        return true;
    }
}function hasSpecialChars(fieldValue) {    var iChars = "^{}<>";    var flag = false;    for(var i = 0; i < fieldValue.length; i++) {        if(iChars.indexOf(fieldValue.charAt(i)) != -1) {            flag = true;            break;        }    }    if(flag) {        return true;    } else {        return false;    }}function hasSpecialCharaters(fieldValue) {
    var iChars = "!@#$%^&*()+=[]\\;,/{}|\"<>";
    var flag = false;    //alert("The Following Characters must be removed: !@#$%^&*()+=[]\\;,/{}|\":<> ");    
    for(var i = 0; i < fieldValue.length; i++) {
        if(iChars.indexOf(fieldValue.charAt(i)) != -1) {            flag = true;            
            break;
        }
    }
    if(flag) {
        return true;
    } else {
        return false;
    }
}//Check For White Space
function hasWhiteSpace(fieldValue) {
    var iChars = "\t\n\r ";
    var flag = false;
    for(var i = 0; i < fieldValue.length; i++) {
        if(iChars.indexOf(fieldValue.charAt(i)) != -1) {            flag = true;
            break;
        }
    }
    if(flag) {
        return true;
    } else {
        return false;
    }
}// This function check for the valid phone number
function isPhone(fieldVal) {
    var strValidChars = "0123456789- ()";
    var blnResult = true;
    for( i = 0; i < fieldVal.length; i++) {        strChar = fieldVal.charAt(i);
        if(strValidChars.indexOf(strChar) == -1) {            blnResult = false;
        }
    }
    if(blnResult == false) {
        return false;
    } else {
        return true;
    }
}//
// This function check for the valid zip code
function isZipCode(fieldVal) {
    var strValidChars = "0123456789";
    var blnResult = true;
    var fldLength = fieldVal.length;
    if(fldLength == 5) {
        for( i = 0; i < fldLength; i++) {            strChar = fieldVal.charAt(i);
            if(strValidChars.indexOf(strChar) == -1) {                blnResult = false;
            }
        }
    } else {        blnResult = false;
    }
    if(blnResult == false) {
        return false;
    } else {
        return true;
    }
}// This function is used to open a pop up window. User need to pass only two parameters
// 1) pageURL like: "userDetails.php?id=2"
// 2) windowName: Name of the pop up window
function ShowDetails(pageURL, windowName) {
    var nLeft, nTop, nWidth, nHeight;    nWidth = 700;    nHeight = 600;    nLeft = screen.width - nWidth - 50;    nTop = screen.height - nHeight - 100;    Window1 = window.open(pageURL, windowName, "dependent=yes,height=" + nHeight + ",width=" + nWidth + ",left=" + nLeft + ",top=" + nTop + ",location=no,menubar=no,resizable=yes,scrollbars=yes");
    Window1.focus();
}function ShowDetailsLarge(pageURL, windowName) {            var nLeft, nTop, nWidth, nHeight;               nWidth = 800;            nHeight = 700;        nLeft = screen.width - nWidth - 50;        nTop = screen.height - nHeight - 100;        Window1 = window.open(pageURL, windowName, "dependent=yes,height=" + nHeight + ",width=" + nWidth + ",left=" + nLeft + ",top=" + nTop + ",location=no,menubar=no,resizable=yes,scrollbars=yes");        Window1.focus();}
function ShowDetailssmall(pageURL, windowName) {
    var nLeft, nTop, nWidth, nHeight;        nWidth = 500;        nHeight = 400;        nLeft = screen.width - nWidth - 50;        nTop = screen.height - nHeight - 100;        Window1 = window.open(pageURL, windowName, "dependent=yes,height=" + nHeight + ",width=" + nWidth + ",left=" + nLeft + ",top=" + nTop + ",location=no,menubar=no,resizable=yes,scrollbars=yes");    
    Window1.focus();
}///for comments
function ShowcommentsNoBars(pageURL, windowName, nWidth, nHeight) {    Window1 = window.open(pageURL, windowName, "dependent=yes,height=" + nHeight + ",width=" + nWidth + ",location=no,menubar=no,resizable=yes,scrollbars=no");
    Window1.focus();
}function Showcomments(pageURL, windowName, nWidth, nHeight) {    Window1 = window.open(pageURL, windowName, "dependent=yes,height=" + nHeight + ",width=" + nWidth + ",location=no,menubar=no,resizable=yes,scrollbars=yes");    Window1.focus();}// This function is used to check and uncheck all check box in the listing page
// check_all: Name of the button on whose click checkAll() function is called
// check_delete[]: Name of the check box against each row
function checkAll() {
    var check_all = document.getElementById('check_all').checked;
    var getCheckBox = document.getElementsByName('check_delete[]');
    // If Check box is checked, then check all checkbox to delete record
    if(check_all) {
        for(var i = 0; i < getCheckBox.length; i++) {
            getCheckBox[i].checked = true;
        }
    } else {
        // If Check box is unchecked, then uncheck all checkbox to delete record
        for(var i = 0; i < getCheckBox.length; i++) {
            getCheckBox[i].checked = false;
        }
    }
}//////// function for uncheck the all check checkbox
function checkItSelf() {
    //alert(myId);
    //var check_myself = document.getElementById(myId).checked;
    var getCheckBox = document.getElementsByName('check_delete[]');
    // If Check box is checked, then check all checkbox to delete record
    var chk = 'none';
    for(var i = 0; i < getCheckBox.length; i++) {
        if(getCheckBox[i].checked == false) {            chk = 'have';
        }
    }
    if(chk == 'have') {
        document.getElementById('check_all').checked = false;
    } else {
        document.getElementById('check_all').checked = true;
    }
}//Add more fields dynamically.
function addField(area, field, limit) {
    if(!document.getElementById)        return;    //Prvent older browsers from getting any further.
    var field_area = document.getElementById(area);
    var all_inputs = field_area.getElementsByTagName("input");    //Get all the input fields in the given area.
    //Find the count of the last element of the list. It will be in the format '<field><number>'. If the
    //  field given in the argument is 'friend_' the last id will be 'friend_4'.
    var last_item = all_inputs.length - 1;
    var last = all_inputs[last_item].id;
    var count = Number(last.split("_")[1]) + 1;
    //If the maximum number of elements have been reached, exit the function.
    //  If the given limit is lower than 0, infinite number of fields can be created.
    if(count > limit && limit > 0)        return;
    field_area.innerHTML += "<li><input name='" + (field + count) + "' id='" + (field + count) + "' type='text' size='26' class='txtFont'/></li>";
    /* if(document.createElement) { //W3C Dom method.
     var li = document.createElement("li");
     var input = document.createElement("input");
     input.id = field+count;
     input.name = field+count;
     input.size = "25";
     input.type = "text"; //Type of field - can be any valid input type like text,file,checkbox etc.
     li.appendChild(input);
     field_area.appendChild(li);
     } else { //Older Method
     field_area.innerHTML += "<li><input name='"+(field+count)+"' id='"+(field+count)+"' type='text' size='26' class='txtFont'/>eytetry</li>";
     }*/
}function confirmOnDelete() {
    if(confirm("Do you really want to delete record")) {
        return true;
    } else {
        return false;
    }
}function emailCheck(emailStr) {
    /* The following variable tells the rest of the function whether or not
     to verify that the address ends in a two-letter country or well-known
     TLD.  1 means check it, 0 means don't. */
    var checkTLD = 1;
    /* The following is the list of known TLDs that an e-mail address must end with. */
    var knownDomsPat = /^(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum)$/;
    /* The following pattern is used to check if the entered e-mail address
     fits the user@domain format.  It also is used to separate the username
     from the domain. */
    var emailPat = /^(.+)@(.+)$/;
    /* The following string represents the pattern for matching all special
     characters.  We don't want to allow special characters in the address.
     These characters include ( ) < > @ , ; : \ " . [ ] */
    var specialChars = "\\(\\)><@,;:\\\\\\\"\\.\\[\\]";
    /* The following string represents the range of characters allowed in a
     username or domainname.  It really states which chars aren't allowed.*/
    var validChars = "\[^\\s" + specialChars + "\]";
    /* The following pattern applies if the "user" is a quoted string (in
     which case, there are no rules about which characters are allowed
     and which aren't; anything goes).  E.g. "jiminy cricket"@disney.com
     is a legal e-mail address. */
    var quotedUser = "(\"[^\"]*\")";
    /* The following pattern applies for domains that are IP addresses,
     rather than symbolic names.  E.g. joe@[123.124.233.4] is a legal
     e-mail address. NOTE: The square brackets are required. */
    var ipDomainPat = /^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/;
    /* The following string represents an atom (basically a series of non-special characters.) */
    var atom = validChars + '+';
    /* The following string represents one word in the typical username.
     For example, in john.doe@somewhere.com, john and doe are words.
     Basically, a word is either an atom or quoted string. */
    var word = "(" + atom + "|" + quotedUser + ")";
    // The following pattern describes the structure of the user
    var userPat = new RegExp("^" + word + "(\\." + word + ")*$");
    /* The following pattern describes the structure of a normal symbolic
     domain, as opposed to ipDomainPat, shown above. */
    var domainPat = new RegExp("^" + atom + "(\\." + atom + ")*$");
    /* Finally, let's start trying to figure out if the supplied address is valid. */
    /* Begin with the coarse pattern to simply break up user@domain into
     different pieces that are easy to analyze. */
    var matchArray = emailStr.match(emailPat);
    if(matchArray == null) {
        /* Too many/few @'s or something; basically, this address doesn't
        even fit the general mould of a valid e-mail address. */
        //error_msg += "Email address seems incorrect (check @ and .'s)";
        return false;
    }
    var user = matchArray[1];
    var domain = matchArray[2];
    // Start by checking that only basic ASCII characters are in the strings (0-127).
    for( i = 0; i < user.length; i++) {
        if(user.charCodeAt(i) > 127) {
            //error_msg += "Ths username contains invalid characters.";
            return false;
        }
    }
    for( i = 0; i < domain.length; i++) {
        if(domain.charCodeAt(i) > 127) {
            //error_msg += "Ths domain name contains invalid characters.";
            return false;
        }
    }
    // See if "user" is valid
    if(user.match(userPat) == null) {
        // user is not valid
        //error_msg += "The username doesn't seem to be valid.";
        return false;
    }
    /* if the e-mail address is at an IP address (as opposed to a symbolic
     host name) make sure the IP address is valid. */
    var IPArray = domain.match(ipDomainPat);
    if(IPArray != null) {
        // this is an IP address
        for(var i = 1; i <= 4; i++) {
            if(IPArray[i] > 255) {
                //error_msg += "Destination IP address is invalid!";
                return false;
            }
        }
        return true;
    }
    // Domain is symbolic name.  Check if it's valid.
    var atomPat = new RegExp("^" + atom + "$");
    var domArr = domain.split(".");
    var len = domArr.length;
    for( i = 0; i < len; i++) {
        if(domArr[i].search(atomPat) == -1) {
            //error_msg += "The domain name does not seem to be valid.";
            return false;
        }
    }
    /* domain name seems valid, but now make sure that it ends in a
     known top-level domain (like com, edu, gov) or a two-letter word,
     representing country (uk, nl), and that there's a hostname preceding
     the domain or country. */
    if(checkTLD && domArr[domArr.length - 1].length != 2 && domArr[domArr.length - 1].search(knownDomsPat) == -1) {
        //error_msg += "The address must end in a well-known domain or two letter " + "country.";
        return false;
    }
    // Make sure there's a host name preceding the domain.
    if(len < 2) {
        //error_msg += "This address is missing a hostname!";
        return false;
    }
    // If we've gotten this far, everything's valid!
    return true;
}function isURL(urlStr) {
    var checkTLD = 1;
    var knownDomsPat = /^(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum)$/;
    if(urlStr.indexOf(" ") != -1) {
        //alert("Spaces are not allowed in a URL");
        return false;
    }
    if(urlStr == "" || urlStr == null) {
        return true;
    }    urlStr = urlStr.toLowerCase();
    var specialChars = "\\(\\)><@,;:\\\\\\\"\\.\\[\\]";
    var validChars = "\[^\\s" + specialChars + "\]";
    var atom = validChars + '+';
    var urlPat = /^(\w*)\.([\-\+a-z0-9]*)\.(\w*)/;
    var matchArray = urlStr.match(urlPat);
    if(matchArray == null) {
        //alert("The URL seems incorrect \ncheck it begins with http://\n and it has 2 .'s");
        return false;
    }
    var user = matchArray[2];
    var domain = matchArray[3];
    for( i = 0; i < user.length; i++) {
        if(user.charCodeAt(i) > 127) {
            //alert("This domain contains invalid characters.");
            return false;
        }
    }
    for( i = 0; i < domain.length; i++) {
        if(domain.charCodeAt(i) > 127) {
            //alert("This domain name contains invalid characters.");
            return false;
        }
    }
    var atomPat = new RegExp("^" + atom + "$");
    var domArr = domain.split(".");
    var len = domArr.length;
    for( i = 0; i < len; i++) {
        if(domArr[i].search(atomPat) == -1) {
            //alert("The domain name does not seem to be valid.");
            return false;
        }
    }
    if(checkTLD && domArr[domArr.length - 1].length != 2 && domArr[domArr.length - 1].search(knownDomsPat) == -1) {
        //error_msg += "The address must end in a well-known domain or two letter " + "country.";
        //alert("The address must end in a well-known domain or two letter " + "country.");
        return false;
    }
    return true;
}