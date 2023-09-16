document.addEventListener("DOMContentLoaded", function() {
    const voteButtons = document.querySelectorAll(".Vote-btn");

    voteButtons.forEach(button => {
        button.addEventListener("click", function(event) {
            event.preventDefault();
            let form = this.closest("form");
            let formData = new FormData(form);
            
            let pollId = formData.get("FormType");
            let selectedOptionIndex = formData.get("selected_option");

            let xhr = new XMLHttpRequest();
            xhr.open("GET", "ajax_pollvote.php?pollId=" + pollId + "&selectedOptionIndex=" + selectedOptionIndex, true);
            xhr.send();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        let VoteCount = JSON.parse(xhr.responseText);
                        let VisibleContainers = form.querySelectorAll(".i" + pollId);
                        for (let i = 0; i < VisibleContainers.length; i++) {
                            VisibleContainers[i].style.display = 'block';
                            VisibleContainers[i].childNodes[1].style.width = VoteCount[i] + '%';
                            VisibleContainers[i].childNodes[1].childNodes[1].innerHTML = VoteCount[i] + '%';

                        }
                        let voteButton = form.querySelector(".Vote-btn");
                        voteButton.style.display = 'none';
                    }
                    else {
                        console.log("Vote processing failed");
                    }
                }
            }
        })
    })
})