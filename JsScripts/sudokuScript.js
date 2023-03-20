let finalScore = 0;

let timer;
let solved = new Array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
let solved2 = "";
let unSolved2 = new Array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
let unSolved = "";

var sudoku = new Array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);

// ... and we solve it!!


// given a sudoku cell, returns the row
function returnRow(cell) {
	return Math.floor(cell / 9);
}

// given a sudoku cell, returns the column
function returnCol(cell) {
	return cell % 9;
}

// given a sudoku cell, returns the 3x3 block
function returnBlock(cell) {
	return Math.floor(returnRow(cell) / 3) * 3 + Math.floor(returnCol(cell) / 3);
}

// given a number, a row and a sudoku, returns true if the number can be placed in the row
function isPossibleRow(number,row,sudoku) {
	for (var i=0; i<=8; i++) {
		if (sudoku[row*9+i] == number) {
			return false;
		}
	}
	return true;
}

// given a number, a column and a sudoku, returns true if the number can be placed in the column
function isPossibleCol(number,col,sudoku) {
	for (var i=0; i<=8; i++) {
		if (sudoku[col+9*i] == number) {
			return false;
		}
	}
	return true;
}

// given a number, a 3x3 block and a sudoku, returns true if the number can be placed in the block
function isPossibleBlock(number,block,sudoku) {
	for (var i=0; i<=8; i++) {
		if (sudoku[Math.floor(block/3)*27+i%3+9*Math.floor(i/3)+3*(block%3)] == number) {
			return false;
		}
	}
	return true;
}

// given a cell, a number and a sudoku, returns true if the number can be placed in the cell
function isPossibleNumber(cell,number,sudoku) {
	var row = returnRow(cell);
	var col = returnCol(cell);
	var block = returnBlock(cell);
	return isPossibleRow(number,row,sudoku) && isPossibleCol(number,col,sudoku) && isPossibleBlock(number,block,sudoku);
}

// given a row and a sudoku, returns true if it's a legal row
function isCorrectRow(row,sudoku) {
	var rightSequence = new Array(1,2,3,4,5,6,7,8,9);
	var rowTemp= new Array();
	for (var i=0; i<=8; i++) {
		rowTemp[i] = sudoku[row*9+i];
	}
	rowTemp.sort();
	return rowTemp.join() == rightSequence.join();
}

// given a column and a sudoku, returns true if it's a legal column
function isCorrectCol(col,sudoku) {
	var rightSequence = new Array(1,2,3,4,5,6,7,8,9);
	var colTemp= new Array();
	for (var i=0; i<=8; i++) {
		colTemp[i] = sudoku[col+i*9];
	}
	colTemp.sort();
	return colTemp.join() == rightSequence.join();
}

// given a 3x3 block and a sudoku, returns true if it's a legal block 
function isCorrectBlock(block,sudoku) {
	var rightSequence = new Array(1,2,3,4,5,6,7,8,9);
	var blockTemp= new Array();
	for (var i=0; i<=8; i++) {
		blockTemp[i] = sudoku[Math.floor(block/3)*27+i%3+9*Math.floor(i/3)+3*(block%3)];
	}
	blockTemp.sort();
	return blockTemp.join() == rightSequence.join();
}

// given a sudoku, returns true if the sudoku is solved
function isSolvedSudoku(sudoku) {
	for (var i=0; i<=8; i++) {
		if (!isCorrectBlock(i,sudoku) || !isCorrectRow(i,sudoku) || !isCorrectCol(i,sudoku)) {
			return false;
		}
	}
	return true;
}

// given a cell and a sudoku, returns an array with all possible values we can write in the cell
function determinePossibleValues(cell,sudoku) {
	var possible = new Array();
	for (var i=1; i<=9; i++) {
		if (isPossibleNumber(cell,i,sudoku)) {
			possible.unshift(i);
		}
	}
	return possible;
}

// given an array of possible values assignable to a cell, returns a random value picked from the array
function determineRandomPossibleValue(possible,cell) {
	var randomPicked = Math.floor(Math.random() * possible[cell].length);
	return possible[cell][randomPicked];
}

// given a sudoku, returns a two dimension array with all possible values 
function scanSudokuForUnique(sudoku) {
	var possible = new Array();
	for (var i=0; i<=80; i++) {
		if (sudoku[i] == 0) {
			possible[i] = new Array();
			possible[i] = determinePossibleValues(i,sudoku);
			if (possible[i].length==0) {
				return false;
			}
		}
	}
	return possible;
}

// given an array and a number, removes the number from the array
function removeAttempt(attemptArray,number) {
	var newArray = new Array();
	for (var i=0; i<attemptArray.length; i++) {
		if (attemptArray[i] != number) {
			newArray.unshift(attemptArray[i]);
		}
	}
	return newArray;
}

// given a two dimension array of possible values, returns the index of a cell where there are the less possible numbers to choose from
function nextRandom(possible) {
	var max = 9;
	var minChoices = 0;
	for (var i=0; i<=80; i++) {
		if (possible[i]!=undefined) {
			if ((possible[i].length<=max) && (possible[i].length>0)) {
				max = possible[i].length;
				minChoices = i;
			}
		}
	}
	return minChoices;
}

// given a sudoku, solves it
function solve(sudoku, diff) {
	var saved = new Array();
	var savedSudoku = new Array();
	var i=0;
	var nextMove;
	var whatToTry;
	var attempt;
	while (!isSolvedSudoku(sudoku)) {
		i++;
		nextMove = scanSudokuForUnique(sudoku);
		if (nextMove == false) {
			nextMove = saved.pop();
			sudoku = savedSudoku.pop();
		}
		whatToTry = nextRandom(nextMove);
		attempt = determineRandomPossibleValue(nextMove,whatToTry);
		if (nextMove[whatToTry].length>1) {
			nextMove[whatToTry] = removeAttempt(nextMove[whatToTry],attempt);
			saved.push(nextMove.slice());
			savedSudoku.push(sudoku.slice());
		}
		sudoku[whatToTry] = attempt;
	}

    for (var i=0; i<=8; i++) {
		for (var j=0; j<=8; j++) {
            solved2 += sudoku[i*9+j];
			solved[i*9+j] = sudoku[i*9+j];
		}
	}

    unSolved2 = sudoku;

	showSudoku(sudoku,i);
    removeSomeIndexs(solved2,diff);
}

// given a solved sudoku and the number of steps, prints out the sudoku
function showSudoku(sudoku,i) {
	var sudokuText = "";
	var solved = "\n\nSolved in "+i+" steps";
	for (var i=0; i<=8; i++) {
		for (var j=0; j<=8; j++) {
			sudokuText+=" ";
			sudokuText+=sudoku[i*9+j];
			sudokuText+=" ";
			if (j!=8) {
				sudokuText+="|";
			}
		}
		if (i!=8) {
			sudokuText+="\n---+---+---+---+---+---+---+---+---\n";
		}
	}
	sudokuText+=solved;
	
}

function highLight(sudoku, i){

}

function removeSomeIndexs(sudoku, dif){
	// easy 
	let randCount = Math.floor(Math.random() * (dif - 3 + 1)) + 3;
	if(randCount >= 7) dif = dif -1;
	for(i = 0; i <= randCount-1; i++){
        let randIndex = Math.floor(Math.random() * (8 - 0 + 1)) + 0;
		if(randIndex < 3)
		{
			if(unSolved2[randIndex] != '-')
			{
				unSolved2[randIndex] = '-';
			}else
			{
				i--;
			}
			
		}
		if(randIndex >= 3 & randIndex < 6)
		{
			if(unSolved2[randIndex + 6] != '-')
			{
				unSolved2[randIndex + 6] = '-';
			}else
			{
				i--;
			}
			
		}
		if(randIndex >= 6)
		{
			if(unSolved2[randIndex + 12] != '-')
			{
				unSolved2[randIndex + 12] = '-';
			}else
			{
				i--;
			}
			
		}
        
    }

	randCount = Math.floor(Math.random() * (dif - 3 + 1)) + 3;
	if(randCount >= 7) dif = dif -1;
	for(i = 0; i <= randCount-1; i++){
        let randIndex = Math.floor(Math.random() * (8 - 0 + 1)) + 0;
		if(randIndex < 3)
		{
			if(unSolved2[randIndex + 3] != '-')
			{
				unSolved2[randIndex + 3] = '-';
			}else
			{
				i--;
			}
			
		}
		if(randIndex >= 3 & randIndex < 6)
		{
			if(unSolved2[randIndex + 9] != '-')
			{
				unSolved2[randIndex + 9] = '-';
			}else
			{
				i--;
			}
			
		}
		if(randIndex >= 6)
		{
			if(unSolved2[randIndex + 15] != '-')
			{
				unSolved2[randIndex + 15] = '-';
			}else
			{
				i--;
			}
			
		}
	}

	randCount = Math.floor(Math.random() * (dif - 3 + 1)) + 3;
	if(randCount >= 7) dif = dif -1;
	for(i = 0; i <= randCount-1; i++){
        let randIndex = Math.floor(Math.random() * (8 - 0 + 1)) + 0;
		if(randIndex < 3)
		{
			if(unSolved2[randIndex + 6] != '-')
			{
				unSolved2[randIndex + 6] = '-';
			}else
			{
				i--;
			}
			
		}
		if(randIndex >= 3 & randIndex < 6)
		{
			if(unSolved2[randIndex + 12] != '-')
			{
				unSolved2[randIndex + 12] = '-';
			}else
			{
				i--;
			}
			
		}
		if(randIndex >= 6)
		{
			if(unSolved2[randIndex + 18] != '-')
			{
				unSolved2[randIndex + 18] = '-';
			}else
			{
				i--;
			}
			
		}
	}

	randCount = Math.floor(Math.random() * (dif - 3 + 1)) + 3;
	if(randCount >= 7) dif = dif -1;
	for(i = 0; i <= randCount-1; i++){
        let randIndex = Math.floor(Math.random() * (8 - 0 + 1)) + 0;
		if(randIndex < 3)
		{
			if(unSolved2[randIndex + 27] != '-')
			{
				unSolved2[randIndex + 27] = '-';
			}else
			{
				i--;
			}
			
		}
		if(randIndex >= 3 & randIndex < 6)
		{
			if(unSolved2[randIndex + 33] != '-')
			{
				unSolved2[randIndex + 33] = '-';
			}else
			{
				i--;
			}
			
		}
		if(randIndex >= 6)
		{
			if(unSolved2[randIndex + 39] != '-')
			{
				unSolved2[randIndex + 39] = '-';
			}else
			{
				i--;
			}
			
		}
	}

	randCount = Math.floor(Math.random() * (dif - 3 + 1)) + 3;
	if(randCount >= 7) dif = dif -1;
	for(i = 0; i <= randCount-1; i++){
        let randIndex = Math.floor(Math.random() * (8 - 0 + 1)) + 0;
		if(randIndex < 3)
		{
			if(unSolved2[randIndex + 30] != '-')
			{
				unSolved2[randIndex + 30] = '-';
			}else
			{
				i--;
			}
			
		}
		if(randIndex >= 3 & randIndex < 6)
		{
			if(unSolved2[randIndex + 36] != '-')
			{
				unSolved2[randIndex + 36] = '-';
			}else
			{
				i--;
			}
			
		}
		if(randIndex >= 6)
		{
			if(unSolved2[randIndex + 42] != '-')
			{
				unSolved2[randIndex + 42] = '-';
			}else
			{
				i--;
			}
			
		}
	}

	randCount = Math.floor(Math.random() * (dif - 3 + 1)) + 3;
	if(randCount >= 7) dif = dif -1;
	for(i = 0; i <= randCount-1; i++){
        let randIndex = Math.floor(Math.random() * (8 - 0 + 1)) + 0;
		if(randIndex < 3)
		{
			if(unSolved2[randIndex + 33] != '-')
			{
				unSolved2[randIndex + 33] = '-';
			}else
			{
				i--;
			}
			
		}
		if(randIndex >= 3 & randIndex < 6)
		{
			if(unSolved2[randIndex + 39] != '-')
			{
				unSolved2[randIndex + 39] = '-';
			}else
			{
				i--;
			}
			
		}
		if(randIndex >= 6)
		{
			if(unSolved2[randIndex + 45] != '-')
			{
				unSolved2[randIndex + 45] = '-';
			}else
			{
				i--;
			}
			
		}
	}

	randCount = Math.floor(Math.random() * (dif - 3 + 1)) + 3;
	if(randCount >= 7) dif = dif -1;
	for(i = 0; i <= randCount-1; i++){
        let randIndex = Math.floor(Math.random() * (8 - 0 + 1)) + 0;
		if(randIndex < 3)
		{
			if(unSolved2[randIndex + 54] != '-')
			{
				unSolved2[randIndex + 54] = '-';
			}else
			{
				i--;
			}
			
		}
		if(randIndex >= 3 & randIndex < 6)
		{
			if(unSolved2[randIndex + 60] != '-')
			{
				unSolved2[randIndex + 60] = '-';
			}else
			{
				i--;
			}
			
		}
		if(randIndex >= 6)
		{
			if(unSolved2[randIndex + 66] != '-')
			{
				unSolved2[randIndex + 66] = '-';
			}else
			{
				i--;
			}
			
		}
	}

	randCount = Math.floor(Math.random() * (dif - 3 + 1)) + 3;
	for(i = 0; i <= randCount-1; i++){
        let randIndex = Math.floor(Math.random() * (8 - 0 + 1)) + 0;
		if(randIndex < 3)
		{
			if(unSolved2[randIndex + 57] != '-')
			{
				unSolved2[randIndex + 57] = '-';
			}else
			{
				i--;
			}
			
		}
		if(randIndex >= 3 & randIndex < 6)
		{
			if(unSolved2[randIndex + 63] != '-')
			{
				unSolved2[randIndex + 63] = '-';
			}else
			{
				i--;
			}
			
		}
		if(randIndex >= 6)
		{
			if(unSolved2[randIndex + 69] != '-')
			{
				unSolved2[randIndex + 69] = '-';
			}else
			{
				i--;
			}
			
		}
	}

	randCount = Math.floor(Math.random() * (dif - 3 + 1)) + 3;
	for(i = 0; i <= randCount-1; i++){
        let randIndex = Math.floor(Math.random() * (8 - 0 + 1)) + 0;
		if(randIndex < 3)
		{
			if(unSolved2[randIndex + 60] != '-')
			{
				unSolved2[randIndex + 60] = '-';
			}else
			{
				i--;
			}
			
		}
		if(randIndex >= 3 & randIndex < 6)
		{
			if(unSolved2[randIndex + 66] != '-')
			{
				unSolved2[randIndex + 66] = '-';
			}else
			{
				i--;
			}
			
		}
		if(randIndex >= 6)
		{
			if(unSolved2[randIndex + 72] != '-')
			{
				unSolved2[randIndex + 72] = '-';
			}else
			{
				i--;
			}
			
		}
	}


    // for(i = 0; i <= dif-1; i++){
    //     let randIndex = Math.floor(Math.random() * (x - 0 + 1)) + 0;
    //     unSolved2[randIndex] = '-';
    //     x--;
    // }

    for (var i=0; i<=8; i++) {
		for (var j=0; j<=8; j++) {
            unSolved += unSolved2[i*9+j];
		}
	}

showSudoku(unSolved2,1);


}


var numSelected = null;
var tileSelected = null;

var errors = 0;

var board = [
    "--74916-5",
    "2---6-3-9",
    "-----7-1-",
    "-586----4",
    "--3----9-",
    "--62--187",
    "9-4-7---2",
    "67-83----",
    "81--45---"
]

var solution = [
    "387491625",
    "241568379",
    "569327418",
    "758619234",
    "123784596",
    "496253187",
    "934176852",
    "675832941",
    "812945763"
]

window.onload = function() {
	let easy = document.getElementById('easy');
    let normal = document.getElementById('normal');
    let hard = document.getElementById('hard');
	let overlays = Array.from(document.getElementsByClassName('overlay-text'));
	let main_overlay = document.getElementById('main_overlay');

	easy.addEventListener('click', () => { 
		document.getElementById("gameDif").value = "EASY";
		finalScore = 1000;
		solve(sudoku, 4);
        overlays.forEach(overlay => {
                overlay.classList.remove('visible');
        });

        setGame();
    });

	normal.addEventListener('click', () => {
		document.getElementById("gameDif").value = "MEDIUM";
		finalScore = 3000;
		solve(sudoku, 6);
        overlays.forEach(overlay => {
                overlay.classList.remove('visible');
        });

        setGame();
    });

	hard.addEventListener('click', () => { 
		document.getElementById("gameDif").value = "HARD";
		finalScore = 7000;
		solve(sudoku, 8);
        overlays.forEach(overlay => {
                overlay.classList.remove('visible');
        });

        setGame();
    });

	// document.getElementById('victory-txt').addEventListener('click', () => { 
    //     document.getElementById('victory-txt').classList.remove('visible');
    //     main_overlay.classList.add('visible');
    // });
    
    document.getElementById('over-txt').addEventListener('click', () => { 
        document.getElementById('over-txt').classList.remove('visible');
        main_overlay.classList.add('visible');
    });

	

}

function setGame(diff) {
    for (let i = 1; i <= 9; i++) {
        let number = document.createElement("div");
        number.id = i
        number.innerText = i;
        number.addEventListener("click", selectNumber);
        number.classList.add("number");
        document.getElementById("digits").appendChild(number);
    }

	var sec = 0;
    timer = setInterval( function(){
        document.getElementById("time").innerHTML=++sec;
    }, 1000);

    for (let r = 0; r < 9; r++) {
        for (let c = 0; c < 9; c++) {
            let tile = document.createElement("div");
            tile.id = r.toString() + "-" + c.toString();
            if (unSolved[r*9+c] != "-") {
                tile.innerText = unSolved[r*9+c];
                tile.classList.add("tile-start");
            }
            if (r == 2 || r == 5) {
                tile.classList.add("horizontal-line");
            }
            if (c == 2 || c == 5) {
                tile.classList.add("vertical-line");
            }
            tile.addEventListener("click", selectTile);
            tile.classList.add("tile");
            document.getElementById("board").append(tile);
        }
    }
}

function selectNumber(){
    if (numSelected != null) {
        numSelected.classList.remove("number-selected");
		for (let r = 0; r < 9; r++) {
			for (let c = 0; c < 9; c++) {
				let tile = document.getElementsByClassName("tile");
				if (unSolved[r*9+c] != "-") {
					tile[r*9+c].style.background = 'whitesmoke';
				}
			}
		}
    }
    numSelected = this;
    numSelected.classList.add("number-selected");
	for (let r = 0; r < 9; r++) {
        for (let c = 0; c < 9; c++) {
            let tile = document.getElementsByClassName("tile");
            if (unSolved[r*9+c] == this.innerText) {
                tile[r*9+c].style.background = 'red';
            }
        }
    }
}

function selectTile() {
    if (numSelected) {
        if (this.innerText != "") {
            return;
        }

        let coords = this.id.split("-");
        let r = parseInt(coords[0]);
        let c = parseInt(coords[1]);

        if (solved2[r*9+c] == numSelected.id) {
            this.innerText = numSelected.id;
			unSolved2[r*9+c] = numSelected.id;
			console.log(unSolved2[r*9+c]);
        }
        else {
            errors += 1;
            document.getElementById("errors").innerText = errors;
        }

		if(arrayEquals(unSolved2, solved))
		{
			document.getElementById('victory-txt').classList.add('visible');
			clearInterval(timer);
			let timeLeft = document.getElementById("time").innerText;
			console.log(finalScore);
			finalScore -= errors*20;
			finalScore -= Number(timeLeft) * 2;
			console.log("Po zmniejszeniu");
			console.log(finalScore);
			if(finalScore <= 0 ){
			    console.log("Zero");
				finalScore = 0;
				document.getElementById("lb").style.display = 'none';
			}
			document.getElementById("endScore").innerText = finalScore;
			document.getElementById("gameTime").value = timeLeft;
			document.getElementById("scoreInput").value = finalScore;
			
		}
    }
}

function arrayEquals(a, b) {
    return Array.isArray(a) &&
        Array.isArray(b) &&
        a.length === b.length &&
        a.every((val, index) => val == b[index]);
}

const hide = setInterval(function() {
    document.getElementById("scoreInput").style.display = "none";
	document.getElementById("scoreInput").value = finalScore;
    document.getElementById("gameInput").style.display = "none";
    document.getElementById("gameDif").style.display = "none";
}, 1000);