// For login Page Functions
function checkUserName(UserName) {
    let UserNameRegEx = /^[a-zA-Z0-9_]+$/;

    if (UserNameRegEx.test(UserName)) {
        return true;
    }
    return false;
}

function checkPassword(password) {
    let passwordRegEx = /^(?=.{8,})(?=.*[^a-zA-Z])/;

    if (password.length >= 8 && passwordRegEx.test(password)) {
        return true;
    }
    return false;
}

function validateUserName(event) {
    let UserName = event.target;
    let ptag = document.getElementsByClassName("error-text")[0];

    if (!checkUserName(UserName.value)) {
        if (ptag.classList.contains("hidden")) {
            ptag.classList.remove("hidden");
        }
        if (!UserName.hasAttribute("style")) {
            UserName.setAttribute("style", "border: 1px solid red");
        }
        return false;
    }
    else {
        if (!ptag.classList.contains("hidden")) {
            ptag.classList.add("hidden");
        }
        if (UserName.hasAttribute("style")) {
            UserName.removeAttribute("style", "border: 1px solid red");
        }
        return true;
    }
}

function validatePassword(event) {
    let PassInput = event.target;
    let ptag = document.getElementsByClassName("error-text")[1];

    if (!checkPassword(PassInput.value)) {
        if (ptag.classList.contains("hidden")) {
            ptag.classList.remove("hidden");
        }
        if (!PassInput.hasAttribute("style")) {
            PassInput.setAttribute("style", "border: 1px solid red");
        }
        return false;
    }
    else {
        if (!ptag.classList.contains("hidden")) {
            ptag.classList.add("hidden");
        }
        if (PassInput.hasAttribute("style")) {
            PassInput.removeAttribute("style", "border: 1px solid red");
        }
        return true;
    }
}

function validateLoginForm(event) {
    let UName = document.getElementById("UserName");
    let PassTag = document.getElementById("Password");
    let ptags = document.getElementsByClassName("error-text");
    let isUNameValid = true;
    let isPassValid = true;

    isUNameValid = validateUserName({target: UName});
    isPassValid = validatePassword({target: PassTag});

    if (!(isUNameValid && isPassValid)) {
        event.preventDefault();
    }
    else {
        console.log("Login SuccessFul");
    }
}

// For SignUp Page Functions
function checkMail(Mail) {
    let MailRegEx = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    return MailRegEx.test(Mail);
}

function checkSignUpPassword(password) {
    let PassRegEx = /^(?=.*[A-Za-z]).+$/;

    return PassRegEx.test(password);
}

function checkAvatar(Avatar) {
    let AvatarRegEx = /^[^\n]+.[a-zA-Z]{3,4}$/;

    return AvatarRegEx.test(Avatar);
}

function validateEmail(event) {
    let Mail = event.target;
    let ptag = document.getElementsByClassName("error-text")[1];

    if (!checkMail(Mail.value)) {
        if (ptag.classList.contains("hidden")) {
            ptag.classList.remove("hidden");
        }
        if (!Mail.hasAttribute("style")) {
            Mail.setAttribute("style", "border: 1px solid red");
        }
        return false;
    }
    else {
        if (!ptag.classList.contains("hidden")) {
            ptag.classList.add("hidden");
        }
        if (Mail.hasAttribute("style")) {
            Mail.removeAttribute("style");
        }
        return true;
    }
}

function validateSignupUserName(event) {
    let UserName = event.target;
    let ptag = document.getElementsByClassName("error-text")[2];

    if (!checkUserName(UserName.value)) {
        if (ptag.classList.contains("hidden")) {
            ptag.classList.remove("hidden");
        }
        if (!UserName.hasAttribute("style")) {
            UserName.setAttribute("style", "border: 1px solid red");
        }
        return false;
    }
    else {
        if (!ptag.classList.contains("hidden")) {
            ptag.classList.add("hidden");
        }
        if (UserName.hasAttribute("style")) {
            UserName.removeAttribute("style");
        }
        return true;
    }
}

function validateSignUpPassword(event) {
    let password = event.target;
    let ptag = document.getElementsByClassName("error-text")[3];
    ptag.textContent = "Password is Invalid";

    if (!checkPassword(password.value)) {
        if (ptag.classList.contains("hidden")) {
            ptag.classList.remove("hidden");
        }
        if (!password.hasAttribute("style")) {
            password.setAttribute("style", "border: 1px solid red");
        }
        return false;
    }
    else {
        if (!ptag.classList.contains("hidden")) {
            ptag.classList.add("hidden");
        }
        if (password.hasAttribute("style")) {
            password.removeAttribute("style");
        }
        return true;
    }
}

function validateCpassword(event) {
    let cpassword = event.target;
    let ptag = document.getElementsByClassName("error-text")[4];
    let password = document.getElementById("password");

    if (password.value != "") {
        if (!checkSignUpPassword(cpassword.value)) {
            ptag.innerHTML = "Password is Invalid";
            if (ptag.classList.contains("hidden")) {
                ptag.classList.remove('hidden');
            }
            if (!cpassword.hasAttribute("style")) {
                cpassword.setAttribute("style", "border: 1px solid red");
            }
            return false;
        }
        else if (cpassword.value != password.value) {
            ptag.innerHTML = "Password doesn't match";
            if (ptag.classList.contains("hidden")) {
                ptag.classList.remove('hidden');
            }
            if (!cpassword.hasAttribute("style")) {
                cpassword.setAttribute("style", "border: 1px solid red");
            }
            return false;
        }
        else {
            if (!ptag.classList.contains("hidden")) {
                ptag.classList.add('hidden');
            }
            if (cpassword.hasAttribute("style")) {
                cpassword.removeAttribute("style", "border: 1px solid red");
            }
            return true;   
        }
    }
    else  {
        ptag.innerHTML = "Fill Password Field first";
        if (ptag.classList.contains("hidden")) {
            ptag.classList.remove("hidden");
        }
        if (!cpassword.hasAttribute("style")) {
            cpassword.setAttribute("style", "border: 1px solid red");
        }
        return false;
    }
}

function isAvatarValid(fileName) {
    // Define the regular expression pattern for valid avatar file names
    let avatarRegex = /\.(jpg|jpeg|png|gif)$/i;

    // Test the given fileName against the regex pattern
    return avatarRegex.test(fileName);
  
}

function validateAvatarField(event) {
    let Avatar = event.target;
    let ptag = document.getElementsByClassName("error-text")[0];

    if (!isAvatarValid(Avatar.value)) {
        if (ptag.classList.contains("hidden")) {
            ptag.classList.remove("hidden");
        }
        if (!Avatar.hasAttribute("style")) {
            Avatar.setAttribute("style", "border: 1px solid red");
        }
        return false;
    }
    else {
        if (!ptag.classList.contains("hidden")) {
            ptag.classList.add("hidden");
        }
        if (Avatar.hasAttribute("style")) {
            Avatar.removeAttribute("style");
        }
        return true;
    }
}




function validateSignUpForm(event) {
    let Mail = document.getElementById("Mail-Address");
    let UName = document.getElementById("UserName");
    let password = document.getElementById("password");
    let cpassword = document.getElementById("Confirmed-Password");
    let Avatar = document.getElementById("ChosenOne");
    
    let isMailValid = true, isUNameValid = true, isPasswordValid = true, iscpasswordValid = true, isValidAvatar = true;
    isMailValid = validateEmail({target: Mail});
    isUNameValid = validateSignupUserName({target: UName});
    isPasswordValid = validateSignUpPassword({target: password}); 
    iscpasswordValid = validateCpassword({target: cpassword});
    isValidAvatar = validateAvatarField({target: Avatar});

    
    if (!(isMailValid && isUNameValid && isPasswordValid && iscpasswordValid && isValidAvatar)) {
        event.preventDefault();
    } 
    else {
        console.log("SignUp SuccessFul");
    }

}


// 3. Even Handlers for YourVote page.
function validateTime(Time) {
    let TimeRegEx = /^(0\d|1\d|2[0-3]):([0-5]\d)$/;

    return TimeRegEx.test(Time);
}

function isValidDate(dateString) {
    // Regular expression for "MM/DD/YYYY" date format
    const datePattern = /^\d{4}[-]\d{2}[-]\d{2}$/;
  
    return datePattern.test(dateString);
}

function isLesserTime(time1, time2) {
    const [hours1, minutes1] = time1.split(":").map(Number);
    const [hours2, minutes2] = time2.split(":").map(Number);
  
    if (hours1 === hours2) {
      // If hours are the same, compare minutes
      return minutes1 < minutes2 ? -1 : 1;
    } else {
      // If hours are different, compare hours
      return hours1 < hours2 ? -1 : 1;
    }
}
  
function compareDates(dateString1, dateString2) {
    const date1 = new Date(dateString1);
    const date2 = new Date(dateString2);
  
    if (date1 > date2) {
      return 1;
    } else if (date1 < date2) {
      return -1;
    } else {
      return 0;
    }
}

function validateStartDate(event) {
    let StartDate = event.target;
    let ptag = document.getElementsByClassName("error-text")[7];
    let EndDate = document.getElementById("EndDate-NewPoll");
    console.log("Startdate: ", StartDate);

    if (isValidDate(EndDate.value) && isValidDate(StartDate.value)) {
        if (compareDates(StartDate.value, EndDate.value) == -1 || compareDates(StartDate.value, EndDate.value) == 0) {
            if (StartDate.hasAttribute("style")) {
                StartDate.removeAttribute("style");
            }
            if (!ptag.classList.contains("hidden")) {
                ptag.classList.add("hidden");
            }
            return true;
        }
        else {
            ptag.textContent = "Entered Date is Greater than EndDate";
            if (!StartDate.hasAttribute("style")) {
                StartDate.setAttribute("style", "border: 1px solid red");
            }
            if (ptag.classList.contains("hidden")) {
                ptag.classList.remove("hidden");
            }
            return false;
        }
        
    }
    else if (isValidDate(StartDate.value)) {
        if (StartDate.hasAttribute("style")) {
            StartDate.removeAttribute("style");
        }
        if (!ptag.classList.contains("hidden")) {
            ptag.classList.add("hidden");
        }
        return true;
    }
    else if (!isValidDate(StartDate.value)) {
        ptag.textContent = "Input Date is not Valid";
            if (!StartDate.hasAttribute("style")) {
                StartDate.setAttribute("style", "border: 1px solid red");
            }
            if (ptag.classList.contains("hidden")) {
                ptag.classList.remove("hidden");
            }
            return false;
    }
}

function validateEndDate(event) {
    let EndDate = event.target;
    let ptag = document.getElementsByClassName("error-text")[9];
    let StartDate = document.getElementById("StartDate-NewPoll");
    console.log("Enddate: ", EndDate.value, EndDate.innerHTML, EndDate.target);

    if (isValidDate(EndDate.value) && isValidDate(StartDate.value)) {
        if (compareDates(StartDate.value, EndDate.value) == -1 || compareDates(StartDate.value, EndDate.value) == 0) {
            if (EndDate.hasAttribute("style")) {
                EndDate.removeAttribute("style");
            }
            if (!ptag.classList.contains("hidden")) {
                ptag.classList.add("hidden");
            }
            return true;
        }
        else {
            ptag.textContent = "Entered Date is less than StartDate";
            if (!EndDate.hasAttribute("style")) {
                EndDate.setAttribute("style", "border: 1px solid red");
            }
            if (ptag.classList.contains("hidden")) {
                ptag.classList.remove("hidden");
            }
            return false;
        }
        
    }
    else if (isValidDate(EndDate.value)) {
        if (EndDate.hasAttribute("style")) {
            EndDate.removeAttribute("style");
        }
        if (!ptag.classList.contains("hidden")) {
            ptag.classList.add("hidden");
        }
        return true;
    }
    else if (!isValidDate(StartDate.value)) {
            ptag.textContent = "Input Date is not Valid";
            if (!EndDate.hasAttribute("style")) {
                EndDate.setAttribute("style", "border: 1px solid red");
            }
            if (ptag.classList.contains("hidden")) {
                ptag.classList.remove("hidden");
            }
            return false;
    }
}

function validateStartTime(event) {
    let StartTime = event.target;
    let ptag = document.getElementsByClassName("error-text")[6];
    let EndTime = document.getElementById("EndTime-NewPoll");
    let StartDate = document.getElementById("StartDate-NewPoll");
    let EndDate =  document.getElementById("EndDate-NewPoll");

    if (validateTime(StartTime.value) && validateTime(EndTime.value)) {
        if (isLesserTime(StartTime.value, EndTime.value) == -1 ) {
            if (StartTime.hasAttribute("style")) {
                StartTime.removeAttribute("style");
            }
            if (!ptag.classList.contains("hidden")) {
                ptag.classList.add("hidden");
            }
            return true;
        }
        else {
            if (isValidDate(StartDate.value) && isValidDate(EndDate.value)) {
                if (compareDates(StartDate.value, EndDate.value) == 1 || compareDates(StartDate.value, EndDate.value) == 0) {
                    ptag.textContent = "Enterd StartTime is Greater than EndTime";
                    if (!StartTime.hasAttribute("style")) {
                        StartTime.setAttribute("style", "border: 1px solid red");
                    }
                    if (ptag.classList.contains("hidden")) {
                        ptag.classList.remove("hidden");
                    }
                    return false;
                }
                else{
                    if (StartTime.hasAttribute("style")) {
                        StartTime.removeAttribute("style");
                    }
                    if (!ptag.classList.contains("hidden")) {
                        ptag.classList.add("hidden");
                    }
                    return true;
                }
            }
            else {
                ptag.textContent = "Enterd StartTime is Greater than EndTime";
                if (!StartTime.hasAttribute("style")) {
                    StartTime.setAttribute("style", "border: 1px solid red");
                }
                if (ptag.classList.contains("hidden")) {
                    ptag.classList.remove("hidden");
                }
                return false;
            }
        }
    }
    else if (validateTime(StartTime.value)) {
        if (StartTime.hasAttribute("style")) {
            StartTime.removeAttribute("style");
        }
        if (!ptag.classList.contains("hidden")) {
            ptag.classList.add("hidden");
        }
        return true;
    }
    else if (!validateTime(StartTime.value)) {
        ptag.textContent = "Input Time is not valid";
        if (!StartTime.hasAttribute("style")) {
            StartTime.setAttribute("style", "border: 1px solid red");
        }
        if (ptag.classList.contains("hidden")) {
            ptag.classList.remove("hidden");
        }
        return false;
        
    }
}

function validateEndTime(event) {
    let EndTime = event.target;
    let ptag = document.getElementsByClassName("error-text")[8];
    let StartTime = document.getElementById("StartTime-NewPoll");
    let StartDate = document.getElementById("StartDate-NewPoll");
    let EndDate =  document.getElementById("EndDate-NewPoll");
    console.log("EndTime: ", EndTime);


    if (validateTime(StartTime.value) && validateTime(EndTime.value)) {
        if (isLesserTime(StartTime.value, EndTime.value) == -1) {
            if (EndTime.hasAttribute("style")) {
                EndTime.removeAttribute("style");
            }
            if (!ptag.classList.contains("hidden")) {
                ptag.classList.add("hidden");
            }
            return true;
        }
        else {
            if (isValidDate(StartDate.value) && isValidDate(EndDate.value)) {
                if (compareDates(StartDate.value, EndDate.value) == 1 || compareDates(StartDate.value, EndDate.value) == 0) {
                    ptag.textContent = "Enterd EndTime is less than StartTime";
                    if (!EndTime.hasAttribute("style")) {
                        EndTime.setAttribute("style", "border: 1px solid red");
                    }
                    if (ptag.classList.contains("hidden")) {
                        ptag.classList.remove("hidden");
                    }
                    return false;
                }
                else {
                    if (EndTime.hasAttribute("style")) {
                        EndTime.removeAttribute("style");
                    }
                    if (!ptag.classList.contains("hidden")) {
                        ptag.classList.add("hidden");
                    }
                    return true;
                }
            }
            else {
                ptag.textContent = "Enterd EndTime is less than StartTime";
                if (!EndTime.hasAttribute("style")) {
                    EndTime.setAttribute("style", "border: 1px solid red");
                }
                if (ptag.classList.contains("hidden")) {
                    ptag.classList.remove("hidden");
                }
                return false;
            }
        }
    }
    else if (validateTime(EndTime.value)) {
        if (EndTime.hasAttribute("style")) {
            EndTime.removeAttribute("style");
        }
        if (!ptag.classList.contains("hidden")) {
            ptag.classList.add("hidden");
        }
        return true;
    }
    else if (!validateTime(EndTime.value)) {
        ptag.textContent = "Input Time is not valid";
        if (!EndTime.hasAttribute("style")) {
            EndTime.setAttribute("style", "border: 1px solid red");
        }
        if (ptag.classList.contains("hidden")) {
            ptag.classList.remove("hidden");
        }
        return false;
        
    }
}

function validateInputField(event, ptagCount, MiniMumWordlimit, MaxwordLimit) {
    let inputField = event.target
    let ptag = document.getElementsByClassName("error-text")[ptagCount];

    if (inputField.value.length >= MiniMumWordlimit && inputField.value.length <= MaxwordLimit) {
        if (ptag.classList.contains("hidden")) {
            ptag.classList.remove("hidden");
        }
        if (inputField.hasAttribute("style")) {
            inputField.removeAttribute("style");
        }

        ptag.textContent = inputField.value.length + " / " + MaxwordLimit;
    
        return true;
    }
    else if (inputField.value.length > MaxwordLimit){
        ptag.textContent = "Input Exceeds Limit " + MaxwordLimit;
        if (ptag.classList.contains('hidden')) {
            ptag.classList.remove("hidden");
        }
        if (!inputField.hasAttribute("style")) {
            inputField.setAttribute("style", "border: 1px solid red");
        }
        return false;
    }
    else if (inputField.value.length < MiniMumWordlimit) {
        ptag.textContent = "Input is below Minimum liimit " + MiniMumWordlimit;
        if (ptag.classList.contains('hidden')) {
            ptag.classList.remove("hidden");
        }
        if (!inputField.hasAttribute("style")) {
            inputField.setAttribute("style", "border: 1px solid red");
        }
        return false;
    }
}

function checkEveryYourVoteField(event) {
    // Get the necessary elements and their values
    const startDate = document.getElementById("StartDate-NewPoll");
    const endDate = document.getElementById("EndDate-NewPoll");
    const startTime = document.getElementById("StartTime-NewPoll");
    const endTime = document.getElementById("EndTime-NewPoll");
    const otherInput1 = document.getElementById("Question-Input");
    const otherInput2 = document.getElementsByClassName("OptionSelection")[0];
    const otherInput3 = document.getElementsByClassName("OptionSelection")[1];
    const otherInput4 = document.getElementsByClassName("OptionSelection")[2];
    const otherInput5 = document.getElementsByClassName("OptionSelection")[3];
    const otherInput6 = document.getElementsByClassName("OptionSelection")[4];

  
    // Call the validation functions and store their results
    const isValidStartDate = validateStartDate({ target: startDate });
    const isValidEndDate = validateEndDate({ target: endDate });
    const isValidStartTime = validateStartTime({ target: startTime });
    const isValidEndTime = validateEndTime({ target: endTime });
    const isValidOtherInput1 = validateInputField({ target: otherInput1 }, 0, 1, 100);
    const isValidOtherInput2 = validateInputField({ target: otherInput2 }, 1, 0, 50);
    const isValidOtherInput3 = validateInputField({ target: otherInput3 }, 2, 0, 50);
    const isValidOtherInput4 = validateInputField({ target: otherInput4 }, 3, 0, 50);
    const isValidOtherInput5 = validateInputField({ target: otherInput5 }, 4, 0, 50);
    const isValidOtherInput6 = validateInputField({ target: otherInput6 }, 5, 0, 50);

  
    // Combine the results using logical AND (&&)
    const isAllFieldsValid =
      isValidStartDate &&
      isValidEndDate &&
      isValidStartTime &&
      isValidEndTime &&
      isValidOtherInput1 &&
      isValidOtherInput2 && isValidOtherInput3 && isValidOtherInput4 && isValidOtherInput5 && isValidOtherInput6;
  
      // Return the final result
        if (isAllFieldsValid) {
            console.log("you've created new poll");
        }
        else {
            event.preventDefault();
        }
  }

function addFormElements(OptionsArray, pollInfoArray, index) {
    let formOptionHTML = '';
    console.log(OptionsArray);
    for (let i = 0; i < OptionsArray.length; i++) {
        let Option = OptionsArray[i];
        formOptionHTML += `
        <input type="radio" name="selected_option" value="${OptionsArray[i]}" id="${i}${pollInfoArray[index]['PollId']}">
        <label for="${i}${pollInfoArray[index]['PollId']}">
            ${OptionsArray[i]}
        </label>
        <br />`;
    }
    return formOptionHTML;
}
function checkForNewPoll() {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log("Requests are successful");
            // console.log("This is happening");
            let pollInfoArray = null;
            pollInfoArray = JSON.parse(this.responseText);

            let hotpollsContainer = null;
            
            // console.log(this.responseText);
            if ('Message' in pollInfoArray) {
                console.log(pollInfoArray['Message']);
            }
            else {
                console.log(pollInfoArray);
                for (let i = pollInfoArray.length - 1; i >= 0; i--) {
                    let newContainer = document.createElement('div');
                newContainer.className = 'topPolls-containers';
                let OptionsArray = pollInfoArray[i]['Options'].split("_ ");

                newContainer.innerHTML = `<div class="UserAvatar-Name">
                        <img src="${pollInfoArray[i]['Avatar']}" alt=formOptionsHTML"User_Avatar" class="Avatar-images" />
                        <small class="UserName">${pollInfoArray[i]['UserName']}</small>
                    </div>
                    <div class="Question-Zone">
                        <p>${pollInfoArray[i]['Question']}</p>
                        <form action="" class="Poll-Options" method="POST">
                            <div>
                            <input type="hidden" name="FormType" value="${pollInfoArray[i]['PollId']}">
                            ${addFormElements(OptionsArray, pollInfoArray, i)}
                            <input type="submit" value="Vote" class="Vote-btn" name="pollSubmit" />
                            </div>
                        </form>
                        <div class="timeZone">
                            <span>${pollInfoArray[i]['GenerationTime']}</span>
                        </div>
                    </div>`;
                hotpollsContainer = document.querySelector('.hotpolls');
                hotpollsContainer.insertBefore(newContainer, hotpollsContainer.firstChild);
                }
                
                for (let i = 0; i < pollInfoArray.length; i++) {
                    hotpollsContainer = document.querySelector(".hotpolls");
                    hotpollsContainer.lastChild.remove();
                    hotpollsContainer = document.querySelector(".hotpolls");
                    hotpollsContainer.lastChild.remove();
                }
            }
        }
    }
    //With request we will also send most recent poll_id which will help us to figure out if there has been added any new poll or not
    let pollId = document.querySelector("input[type=hidden]").getAttribute("value");
    console.log(pollId);
    
    //To send xmlhttprequest to ajax_login.php file via xhr object
    xhr.open("GET", "ajax_login.php?pollId=" + pollId, true);
    xhr.send();
}