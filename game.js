var dice1 = 0;
var dice2 = 0;
var firstRoll = 0;
var gamesPlayed =0;
var gamesToPlay =0;
var turn =0;
var wins =0;
var losses =0;

function initialize() {
    var gameForm = document.getElementById("gameForm");
    printInstructions();
    setButtonListener(gameManager);
}

function setButtonListener(onClickFunction, buttonText) {
    var submitButton = gameForm.elements["submit"];
    buttonText !== undefined ? submitButton.value = buttonText : 0;
    submitButton.onclick = onClickFunction;
}

function printStats() {
    var canvas = document.getElementById("statsCanvas"); 
    var context = canvas.getContext("2d");
    var initialHeight =20;
    context.clearRect(0, 0, canvas.width, canvas.height);
    context.fillText("STATISTICS",110,20);
    var lineSize = 20;
    var stats = new Array();
    stats.push("Games Played: " + gamesPlayed);
    stats.push("Games Won: " + wins);
    stats.push("Games Lost: " + losses);
    for(var i=0; i < stats.length; ++i) {
	context.fillText(stats[i],10, lineSize*(i+1)+initialHeight);
    }

}   

function printInstructions() {
    var canvas = document.getElementById("instructionsCanvas");
    var context = canvas.getContext("2d");
    var initialHeight =20;
    context.fillText("INSTRUCTIONS",110,20);
    var lineSize = 20;
    var instructions = new Array();
    instructions.push("First Roll: Loses if sum is {2,3,12}. Wins if sum is {7,11}.");
    instructions.push("\t\t\tOtherwise the score is recorded.");
    instructions.push("Following Rolls: Lose if sum is {7}. Wins if sum=1st roll.");
    for(var i=0; i < instructions.length; ++i) {
	context.fillText(instructions[i],10, lineSize*(i+1)+initialHeight);
    }
}

function getSum() {
    return dice1+ dice2;
}

function rollDice() {
    dice1 = getRoll();
    dice2 = getRoll();
    if(turn ==0) {
	firstRoll = getSum();
    }
}

function getRoll() {
    return Math.floor(Math.random()*6)+1;
}

function lostRoll() {
    var sum = getSum();
    if(turn == 0 && (sum == 2 || sum == 3 || sum == 12)) {
	return true;
    } else if(turn > 0 && sum ==7) {
	return true;
    } else {
	return false;
    }
}

function wonRoll() {
    var sum = getSum();
    if(turn == 0 && (sum ==7 || sum ==11)){
	return true;
    } else if (turn > 0 && sum == firstRoll) {
	return true;
    } else {
        return false;
    }
}

function hasResults() {
    var gameFinished = false;
    if(wonRoll()) {
	wins++;
	gameFinished = true;
    } else if (lostRoll()) {
	losses++;
	gameFinished = true;
    }
    return gameFinished;
}

function resetGame() {
    turn=0;
    dice1=0;
    dice2=0;
    firstRoll=0;
    wins =0;
    losses=0;
    gamesToPlay =0;
    gamesPlayed=0;
    clearValues();
}

function gameManager() {
    resetGame();
    printStats();
    gamesToPlay = parseInt(gameForm.elements["gamesToPlay"].value);
    if(isNaN(gamesToPlay) || gamesToPlay <1) {
	return;
    }
    gamesPlayed = gamesToPlay;
    setButtonListener(waitForUserInput,"Roll Again");
    waitForUserInput();
}

function updateValues() {
    gameForm.elements["dice1"].value = dice1;
    gameForm.elements["dice2"].value = dice2;
    gameForm.elements["sum"].value = getSum();
    gameForm.elements["firstRollSum"].value = firstRoll;
}

function clearValues() {
    gameForm.elements["dice1"].value = '';
    gameForm.elements["dice2"].value = '';
    gameForm.elements["sum"].value = '';
    gameForm.elements["firstRollSum"].value = '';
}

function setGamesToPlay() {
    gamesToPlay = gameForm.elements["gamesToPlay"].value = gamesToPlay;
}

function getShift(dice) {
    switch(dice) {
	case 0:
	    return 40;
	    break;
	case 1:
	    return 200;
	    break;
    }
    return 0;
}

function getCircles(value) {
    var circles;
    switch(value) {
	case 1:
	    circles = [ [0,0,0],[0,1,0],[0,0,0] ];
	    break;
	case 2:
	    circles = [ [1,0,0],[0,0,0],[0,0,1] ];
	    break;
	case 3:
	    circles = [ [1,0,0],[0,1,0],[0,0,1] ];
	    break;
	case 4:
	    circles = [ [1,0,1],[0,0,0],[1,0,1] ];
	    break;
	case 5:
	    circles = [ [1,0,1],[0,1,0],[1,0,1] ];
	    break;
	case 6:
	    circles = [ [1,0,1],[1,0,1],[1,0,1] ];
	    break;
    }
    return circles;
}

function drawDice(dice,value,context) {
    var verticalShift = 80;
    var radius = 5;
    var color = dice == 0 ? "blue" : "red";
    var horizontalShift = getShift(dice);
    var circlesToDraw = getCircles(value);
    var diceSize = 120;
    var spaceFromEdge = 15;
    var spacingBetweenDots = (diceSize-2*spaceFromEdge)/2;
    context.fillStyle = color;
    context.fillRect(horizontalShift,verticalShift,diceSize,diceSize); 
    context.fillStyle = "white";
    for(var i=0; i < circlesToDraw.length; ++i) {
	for(var j=0; j < circlesToDraw[i].length; ++j) {
	    if(circlesToDraw[j][i] == 1) {
		context.beginPath();
		context.arc(horizontalShift + spaceFromEdge + spacingBetweenDots * i, verticalShift + spaceFromEdge + spacingBetweenDots * j, radius,0, 2*Math.PI );
		context.fill();
	    }
	}
    }
}

function animateDie() {
    //clear canvas
    var canvas = document.getElementById("gameCanvas");
    var context = canvas.getContext("2d");
    context.clearRect(0,0,canvas.width, canvas.height);
    drawDice(0,dice1,context);
    drawDice(1,dice2,context);
}

function waitForUserInput() {
    rollDice();
    updateValues();
    animateDie();
    var finished = hasResults();
    if(finished) { //next game
	printStats();
	turn=0; //this modifies the behavior
	gamesToPlay--;
	setGamesToPlay();
	alert("Game finished! The sum was " + getSum() );
    } else {
	++turn;
    }
    
    if(finished && gamesToPlay == 0) {
	//game is over, submit scores to database?
	submitScores();
	setButtonListener(gameManager,"Start Game");
	return;
    } else if (finished && gamesToPlay > 0) {
	clearValues();
    }
}

function submitScores() {
    var xhttp = new XMLHttpRequest();
    var result = "";
    xhttp.onreadystatechange = function() {
	if (xhttp.readyState == 4 && xhttp.status == 200) {
	    result = xhttp.responseText;
	    if(result === "success") {
		alert("Scores saved");
	    } 
	}
    };
    xhttp.open("POST", "scores.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("wins=" + wins + "&losses=" + losses + "&gamesPlayed=" + gamesPlayed + "&method=submitScores");
}
