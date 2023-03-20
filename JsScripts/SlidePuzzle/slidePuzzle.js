const puzzleContainer = document.querySelector("#puzzle-container")
let puzzle = []
let size = 3
let check = []
let winCon = [1,2,3,4,5,6,7,8,9]
let game = true
let timer
let moves = 0
let randomImage

randomImage = Math.floor(Math.random() * (7 - 2 + 1) + 2)
generatePuzzle()
randomizePuzzle()
renderPuzzle(randomImage)
renderCheckTable()
handleInput()
startTimer()

function startTimer()
{
    var sec = 0;
    timer = setInterval( function(){
        document.getElementById("time").innerHTML=++sec;
    }, 1000);
}

function getRow(pos) {
    return Math.ceil(pos / size)
}

function getCol(pos) {
    const col = pos % size
    if (col === 0) {
        return size
    }
    return col
}

function generatePuzzle() {
    for (let i = 1; i <= size * size; i++) {
        puzzle.push({
            value: i,
            position: i,
            x: (getCol(i) - 1) * 100,
            y: (getRow(i) - 1) * 100,
            disabled: false,
        })
    }
}

function renderPuzzle(rand) {
    document.getElementById("moves").innerText = moves;
    puzzleContainer.innerHTML = ""
    for (let puzzleItem of puzzle) {
        if (puzzleItem.disabled) continue
        puzzleContainer.innerHTML += `
            <div class="puzzle-item puzzle${puzzleItem.value}" style="background-image: url('../Img/SlidePuzzle/bg${rand}.png'); left: ${puzzleItem.x}px; top: ${puzzleItem.y}px;">
                ${puzzleItem.value}
            </div>
        `
    }
}

function renderCheckTable()
{
    for (let puzzleItem of puzzle) {
        check.push(puzzleItem.value);
    }
}

function randomizePuzzle() {
    const randomValues = getRandomValues()
    // console.log(randomValues)
    let i = 0
    for (let puzzleItem of puzzle) {
        puzzleItem.value = randomValues[i]
        i++
    }

    const puzzleWithValueOf9 = puzzle.find((item) => item.value === size * size)
    puzzleWithValueOf9.disabled = true
    // console.log(puzzle)
}

function getRandomValues() {
    const values = []
    for (let i = 1; i <= size * size; i++) {
        values.push(i)
    }

    const randomValues = values.sort(() => Math.random() - 0.5)
    return randomValues
}

function handleInput() {
        document.addEventListener("keydown", handleKeyDown)
}

function handleKeyDown(e) {
    if(game)
    {
        switch (e.key) {
            case "ArrowLeft":
                moveLeft()
                break
            case "ArrowRight":
                moveRight()
                break
            case "ArrowUp":
                moveUp()
                break
            case "ArrowDown":
                moveDown()
                break
        }
        renderPuzzle(randomImage)
    }
    
}

function moveLeft() {
    const emptyPuzzle = getEmptyPuzzle()
    const rightPuzzle = getRightPuzzle()
    if (rightPuzzle) {
        swapPositions(emptyPuzzle, rightPuzzle, true);
        checkIfWin()
    }
}
function moveRight() {
    const emptyPuzzle = getEmptyPuzzle()
    const leftPuzzle = getLeftPuzzle()
    if (leftPuzzle) {
        swapPositions(emptyPuzzle, leftPuzzle, true)
        checkIfWin()
    }
}
function moveUp() {
    const emptyPuzzle = getEmptyPuzzle()
    const belowPuzzle = getBelowPuzzle()
    if (belowPuzzle) {
        swapPositions(emptyPuzzle, belowPuzzle, false)
        checkIfWin()
    }
}
function moveDown() {
    const emptyPuzzle = getEmptyPuzzle()
    const abovePuzzle = getAbovePuzzle()
    if (abovePuzzle) {
        swapPositions(emptyPuzzle, abovePuzzle, false)
        checkIfWin()
    }
}

function swapPositions(firstPuzzle, secondPuzzle, isX = false) {
    moves++
    // position swapping
    let temp = firstPuzzle.position
    firstPuzzle.position = secondPuzzle.position
    secondPuzzle.position = temp

    // Check position

    let temp2 = 0;
    let Index1;
    let Index2;

    for (let i = 0; i <= 8; i++) {
        if(check[i] == firstPuzzle.value)
        {
            Index1 = i;
        }
        if(check[i] == secondPuzzle.value)
        {
            Index2 = i;
        }
    }

    temp2 = check[Index1];
    check[Index1] = secondPuzzle.value;
    check[Index2] = temp2;

    // x position swapping

    if (isX) {
        temp = firstPuzzle.x
        firstPuzzle.x = secondPuzzle.x
        secondPuzzle.x = temp
    } else {
        // must be y
        temp = firstPuzzle.y
        firstPuzzle.y = secondPuzzle.y
        secondPuzzle.y = temp
    }
}

function getRightPuzzle() {
    /* get the puzzle just right to the empty puzzle */
    const emptyPuzzle = getEmptyPuzzle()
    const isRightEdge = getCol(emptyPuzzle.position) === size
    if (isRightEdge) {
        return null
    }
    const puzzle = getPuzzleByPos(emptyPuzzle.position + 1)
    return puzzle
}
function getLeftPuzzle() {
    /* get the puzzle just left to the empty puzzle */
    const emptyPuzzle = getEmptyPuzzle()
    const isLeftEdge = getCol(emptyPuzzle.position) === 1
    if (isLeftEdge) {
        return null
    }
    const puzzle = getPuzzleByPos(emptyPuzzle.position - 1)
    return puzzle
}
function getAbovePuzzle() {
    /* get the puzzle just above to the empty puzzle */
    const emptyPuzzle = getEmptyPuzzle()
    const isTopEdge = getRow(emptyPuzzle.position) === 1
    if (isTopEdge) {
        return null
    }
    const puzzle = getPuzzleByPos(emptyPuzzle.position - size)
    return puzzle
}
function getBelowPuzzle() {
    /* get the puzzle just below to the empty puzzle */
    const emptyPuzzle = getEmptyPuzzle()
    const isBottomEdge = getRow(emptyPuzzle.position) === size
    if (isBottomEdge) {
        return null
    }
    const puzzle = getPuzzleByPos(emptyPuzzle.position + size)
    return puzzle
}

function getEmptyPuzzle() {
    return puzzle.find((item) => item.disabled)
}

function getPuzzleByPos(pos) {
    return puzzle.find((item) => item.position === pos)
}

function checkIfWin()
{
    if(arrayEquals(check, winCon))
    {
        game = false;
        console.log("win");
        clearInterval(timer);
        let score = 4000;
        score -= moves * 10;
        score -= Number(document.getElementById("time").innerHTML) * 2;
        if(score <= 0 ){
            score = 0;
        }
        document.getElementById("endScore").innerText = score;
        document.getElementById("gameTime").value = Number(document.getElementById("time").innerHTML);
        document.getElementById("scoreInput").value = score;
        document.getElementById('victory-txt').classList.add('visible');
        if(score <= 0)
        {
            document.getElementById("lb").style.display = 'none';
        }
    }
}

function arrayEquals(a, b) {
    return Array.isArray(a) &&
        Array.isArray(b) &&
        a.length === b.length &&
        a.every((val, index) => val === b[index]);
}

const hide = setInterval(function() {
    document.getElementById("scoreInput").style.display = "none";
    document.getElementById("gameInput").style.display = "none";
    document.getElementById("gameDif").style.display = "none";
    document.getElementById("gameTime").style.display = "none";
}, 1000);