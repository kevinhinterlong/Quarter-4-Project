//global variables to use when playing the game
//NOTE: this game goes on an honors system
//such that the site doesn't do anything to 
//attempt to track the variables. In other words
//you can set the number of wins to whatever you like.
//Just try it
var dice1 = 0;
var dice2 = 0;
var firstRoll = 0;
var gamesPlayed =0;
var gamesToPlay =0;
var turn =0;
var wins =0;
var losses =0;

//sets the function for the button, gets the game form, and prints the instructions
function initialize() {
    var gameForm = document.getElementById("gameForm");
    printInstructions();
    setButtonListener(gameManager);
}

//tells the button what it should do onclick
function setButtonListener(onClickFunction, buttonText) {
    var submitButton = gameForm.elements["submit"];
    buttonText !== undefined ? submitButton.value = buttonText : 0;
    submitButton.onclick = onClickFunction;
}

//print the number of games played, won, and lost
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

//print the instructions to the game
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

//gets the sum of the dice
function getSum() {
    return dice1+ dice2;
}

//gets a random variable for each dice
//and records the sum if it is the first roll
function rollDice() {
    dice1 = getRoll();
    dice2 = getRoll();
    if(turn ==0) {
	firstRoll = getSum();
    }
}

//returns random integer from 1-6 inclusive
function getRoll() {
    return Math.floor(Math.random()*6)+1;
}

//checks if the user lost the roll
function lostRoll() {
    var sum = getSum();
    if(turn == 0 && (sum == 2 || sum == 3 || sum == 12)) { //first turn
	return true;
    } else if(turn > 0 && sum ==7) { //following turns
	return true;
    } else {
	return false;
    }
}

//checks if the user won the roll
function wonRoll() {
    var sum = getSum();
    if(turn == 0 && (sum ==7 || sum ==11)){ //first turn
	return true;
    } else if (turn > 0 && sum == firstRoll) { //following turns
	return true;
    } else {
        return false;
    }
}

//checks if the user won or lost and returns true when the game is finished
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

//clears all the values for the game
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

//sets the function for the button and the number of games to play
//then the button is used to advance the game
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

//set all of the values which are displayed on the screen
function updateValues() {
    gameForm.elements["dice1"].value = dice1;
    gameForm.elements["dice2"].value = dice2;
    gameForm.elements["sum"].value = getSum();
    gameForm.elements["firstRollSum"].value = firstRoll;
}

//clears all of the values which are displayed on the screen
function clearValues() {
    gameForm.elements["dice1"].value = '';
    gameForm.elements["dice2"].value = '';
    gameForm.elements["sum"].value = '';
    gameForm.elements["firstRollSum"].value = '';
}

//updates the number of games to play in the form
function setGamesToPlay() {
    gamesToPlay = gameForm.elements["gamesToPlay"].value = gamesToPlay;
}

//how much the dice should be shifted horizontally when drawn
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

//returns an int[][] with the circles to be drawn as 1 and blanks as 0
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

//draws a single dice on the canvas
function drawDice(dice,value,context) {
    var verticalShift = 80; //amount to be shifted down
    var radius = 5; //radii of the cirles
    var color = dice == 0 ? "blue" : "red"; //color for dice1 and dice2
    var horizontalShift = getShift(dice); //how much to move horizontally
    var circlesToDraw = getCircles(value); //find out what circles should be drawn
    var diceSize = 120; //the vertical and horizontal size of the dice
    var spaceFromEdge = 15; //how much the cirlces should be moved away from the edges
    var spacingBetweenDots = (diceSize-2*spaceFromEdge)/2; //spacing to be set between dots
    context.fillStyle = color; //set color of dice
    context.fillRect(horizontalShift,verticalShift,diceSize,diceSize);  //draw dice
    context.fillStyle = "white"; //set color of circles
    //draws in all the circles
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

//gets the game canvas and clears it then draws both dice
function animateDie() {
    //clear canvas
    var canvas = document.getElementById("gameCanvas");
    var context = canvas.getContext("2d");
    context.clearRect(0,0,canvas.width, canvas.height);
    drawDice(0,dice1,context);
    drawDice(1,dice2,context);
}

//the button to be clicked while playing the game
function waitForUserInput() {
    rollDice(); //roll dice
    updateValues(); //update numbers shown
    animateDie(); //update dice shown
    var finished = hasResults(); //check if the game has ended
    if(finished) { //if game ended
	printStats(); //print stats
	turn=0; //reset game
	gamesToPlay--; //decrement games to play
	setGamesToPlay(); //update the number of games to play on screen
	alert("Game finished! The sum was " + getSum() ); //alert that the game has ended
    } else { //if the game didn't end then increment the turns
	++turn; 
    }
    
    if(finished && gamesToPlay == 0) { //if the last game finished
	submitScores(); //submit scores to database
	setButtonListener(gameManager,"Start Game"); //reset the button to starting games
	return;
    } else if (finished && gamesToPlay > 0) { //if game finished, but there are more games
	clearValues(); 
    }
}

//send the scores to be saved into the database
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
