var dice1 = 0;
var dice2 = 0;
var firstRoll = 0;
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

function gameManager() {
    gamesToPlay = parseInt(gameForm.elements["gamesToPlay"].value);
    if(isNaN(gamesToPlay) || gamesToPlay <1) {
	return;
    }
    turn=0;
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

function waitForUserInput() {
    rollDice();
    updateValues();
    var finished = hasResults();
    if(finished) { //next game
	turn=0; //this modifies the behavior
	gamesToPlay--;
	setGamesToPlay();
	alert("Game finished! The sum was " + getSum() );
    } else {
	++turn;
    }
    
    if(finished && gamesToPlay == 0) {
	setButtonListener(gameManager,"Start Game");
	return;
    } else if (finished && gamesToPlay > 0) {
	clearValues();
    }
}

