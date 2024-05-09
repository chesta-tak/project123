function setGoal() {
    var goalAmount = parseFloat(document.getElementById("goalAmount").value);
    if (goalAmount > 0) {
        document.getElementById("goalForm").style.display = "none";
        document.getElementById("goalProgress").style.display = "block";
        document.getElementById("displayGoalAmount").innerText = goalAmount.toFixed(2);
    } else {
        alert("Please enter a valid goal amount.");
    }
}
function saveGoal() {
    
    var targetDate = document.getElementById("goal-date").value;
  
    // Display the goal on the dashboard until the target date
    var goalText = "Goal: Save ₹" + goalAmount + " by " + targetDate;
    document.getElementById("goal").innerText = goalText;
  
    alert("Goal set successfully!");
    hideGoalForm();
  }
function deposit() {
    var depositAmount = parseFloat(prompt("Enter the amount you want to deposit:"));
    if (!isNaN(depositAmount) && depositAmount > 0) {
        var currentAmount = parseFloat(document.getElementById("currentAmount").innerText);
        currentAmount += depositAmount;
        document.getElementById("currentAmount").innerText = currentAmount.toFixed(2);
        updateProgress(currentAmount);
        checkGoalReached(currentAmount);
        alert("Deposit successful!");
    } else {
        alert("Please enter a valid deposit amount.");
    }
}
function cancelGoal() {
    // Code to cancel setting the goal
    hideGoalForm();
  }

function withdraw() {
    var withdrawAmount = parseFloat(prompt("Enter the amount you want to withdraw:"));
    if (!isNaN(withdrawAmount) && withdrawAmount > 0) {
        var currentAmount = parseFloat(document.getElementById("currentAmount").innerText);
        if (withdrawAmount <= currentAmount) {
            currentAmount -= withdrawAmount;
            document.getElementById("currentAmount").innerText = currentAmount.toFixed(2);
            updateProgress(currentAmount);
            alert("Withdrawal successful!");
        } else {
            alert("Withdrawal amount exceeds current balance.");
        }
    } else {
        alert("Please enter a valid withdrawal amount.");
    }
}

function updateProgress(currentAmount) {
    var goalAmount = parseFloat(document.getElementById("displayGoalAmount").innerText);
    var progress = (currentAmount / goalAmount) * 100;
    var progressBar = document.getElementById("progressBar");
    var progressLabel = document.getElementById("progressLabel");

    progressBar.style.width = progress + "%";

    // Change color based on progress
    if (progress < 50) {
        progressBar.style.backgroundColor = "#ff0000"; // Red color if progress is less than 50%
    } else if (progress >= 50 && progress < 100) {
        progressBar.style.backgroundColor = "#ffa500"; // Orange color if progress is between 50% and 100%
    } else {
        progressBar.style.backgroundColor = "#00ff00"; // Green color if progress is 100% or more
    }

    progressLabel.innerText = progress.toFixed(2) + "%";
}


function checkGoalReached(currentAmount) {
    var goalAmount = parseFloat(document.getElementById("displayGoalAmount").innerText);
    if (currentAmount >= goalAmount) {
        alert("Congratulations! You have reached your savings goal!");
    }
}
