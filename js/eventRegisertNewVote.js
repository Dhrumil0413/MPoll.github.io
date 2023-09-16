let StartTime = document.getElementById("StartTime-NewPoll");
let EndTime = document.getElementById("EndTime-NewPoll");
let StartDate = document.getElementById("StartDate-NewPoll");
let EndDate = document.getElementById("EndDate-NewPoll");
let InputQuestion = document.getElementById("Question-Input");

StartDate.addEventListener("blur", validateStartDate);
StartTime.addEventListener("blur", validateStartTime);
EndTime.addEventListener("blur", validateEndTime);
EndDate.addEventListener("blur", validateEndDate);
InputQuestion.addEventListener("input", function(event) {
    validateInputField(event, 0, 1, 100);
});
let OptionsList = document.getElementsByClassName("OptionSelection");

for (let i = 1; i <= 5; i++) {
    OptionsList[i-1].addEventListener("input", function(event) {
        validateInputField(event, i, 0, 50)
    });
}

let CreatPollBtn = document.querySelector(".DateTime-NewPoll-Container");
CreatPollBtn.addEventListener("submit", checkEveryYourVoteField);
