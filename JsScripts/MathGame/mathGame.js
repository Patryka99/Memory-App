class AudioController {
    constructor(){
        this.flipSound = new Audio('../Audio/Flip.wav');
        this.matchSound = new Audio('../Audio/Match.wav');
        this.victorySound = new Audio('../Audio/Victory.wav');
        this.gameOverSound = new Audio('../Audio/Game-Over.wav');
    }
    
    flip() {
        this.flipSound.play();
    }
    match() {
        this.matchSound.play();
    }
    victory() {
        this.victorySound.play();
    }
    gameover() {
        this.gameOverSound.play();
    }
    
}

let timeLeft = 10;
let score = 0;
let round = 0;
let correct = 0;
let timeCountDown;
let difTime = 0;
let dif = 'EASY';

function startGame()
{
    timeLeft = difTime;
    if(dif == 'HARD')
    {
        document.getElementById("btn5").style.display = 'inline-flex';
        document.getElementById("btn6").style.display = 'inline-flex';
    }
    if(dif == 'EASY') nextQuestionEasy();
    if(dif == 'MEDIUM') nextQuestionMedium();
    if(dif == 'HARD') nextQuestionHard();

    startTimer();
}

function startTimer()
{
    document.getElementById("time").innerHTML = timeLeft;
    timeCountDown = setInterval(function(){
        timeLeft -= 1;
        document.getElementById("time").innerHTML = timeLeft;
        if(timeLeft == 0)
        {
            gameOver();
        }
    },1000);
}

function gameOver()
{
    clearInterval(timeCountDown);
    document.getElementById('victory-txt').classList.add('visible');
    document.getElementById('endScore').innerHTML = score;
    document.getElementById("scoreInput").value = score;
    document.getElementById("gameDif").value = dif;
    document.getElementById("btn1").disabled = true;
    document.getElementById("btn2").disabled = true;
    document.getElementById("btn3").disabled = true;
    document.getElementById("btn4").disabled = true;
    document.getElementById("btn5").disabled = true;
    document.getElementById("btn6").disabled = true;
    if(score <= 0)
    {
        document.getElementById("lb").style.display = 'none';
    }
}

function getRandomNumber(a){
    return Math.floor(Math.random()*a);
}

function getRandomOp()
{
    let opIndex = Math.floor(Math.random()*4);
    let op = ['*' , '-', '+', '/'];
    return op[opIndex];
}

function nextQuestionEasy()
{
    let operationDiv = document.getElementById("operation");

    let firstNum = getRandomNumber(12);
    let SecondNum = getRandomNumber(12);
    let op = getRandomOp();
    if(op == '/')
    {
        while (SecondNum == 0 || firstNum % SecondNum != 0)
            {
                firstNum = getRandomNumber(12);
                SecondNum = getRandomNumber(12);
            }
    }

    let str = firstNum + " " + op + " " + SecondNum;
    correct = eval(str);
    operationDiv.innerHTML = str;


    var arr = [];
    arr.push(correct);
    while(arr.length < 7){
        if(op == '*')
        {
            var r = Math.ceil(Math.random() * 12) * Math.ceil(Math.random() * 12);
            if(arr.indexOf(r) === -1) arr.push(r);
        }else if(op == '-')
        {
            var r = Math.ceil(Math.random() * 12) - Math.ceil(Math.random() * 12);
            if(arr.indexOf(r) === -1) arr.push(r);
        }else if(op == '+')
        {
            var r = Math.ceil(Math.random() * 12) + Math.ceil(Math.random() * 12);
            if(arr.indexOf(r) === -1) arr.push(r);
        }else
        {
            let fn = Math.ceil(Math.random() * 12);
            let sn = 0;
            while (sn == 0 || fn % sn != 0)
            {
                sn = Math.ceil(Math.random() * 12);
            }
            var r = fn * sn;
            if(arr.indexOf(r) === -1) arr.push(r);
        }
    }
    document.getElementById("btn1").innerHTML = arr[1];
    document.getElementById("btn2").innerHTML = arr[2];
    document.getElementById("btn3").innerHTML = arr[3];
    document.getElementById("btn4").innerHTML = arr[4];

    let correctIndex = Math.floor(Math.random()*4) + 1;
    let correctId = "btn" + correctIndex;
    document.getElementById(correctId).innerHTML = correct;

}

function nextQuestionMedium()
{
    let operationDiv = document.getElementById("operation");

    var d = Math.random();
    let numQuest;
    if(d < 0.3) numQuest = 2;
    else numQuest = 3;

    let maxNumber = 21;

    let op = getRandomOp();
    let op2;
    
    if(numQuest == 3) op2 = getRandomOp();

    if (numQuest == 3) if(op == '/' || op2 == '/' || op == '*' || op2 == '*') maxNumber = 12;

    let firstNum = getRandomNumber(maxNumber);
    let SecondNum = getRandomNumber(maxNumber);
    let thirdNum;

    if(numQuest == 3) thirdNum = getRandomNumber(maxNumber);

    if(numQuest == 3) if(op == '/' && op2 == '/')
        {
            while (SecondNum == 0 || thirdNum == 0 || eval(firstNum + " " + op + " " + SecondNum + " " + op2 + " " + thirdNum) % 1 != 0)
            {
                SecondNum = getRandomNumber(maxNumber);
                thirdNum = getRandomNumber(maxNumber);
            }
        }
    if(op == '/')
        {
            while (SecondNum == 0 || firstNum % SecondNum != 0)
            {
                SecondNum = getRandomNumber(maxNumber);
            }
        }
    if(op2 == '/')
        {
            while(thirdNum == 0 || eval(firstNum + " " + op + " " + SecondNum + " " + op2 + " " + thirdNum) % 1 != 0)
            {
                thirdNum = getRandomNumber(maxNumber);
            }
        }
    let str;
    if(numQuest == 3) str = firstNum + " " + op + " " + SecondNum + " " + op2 + " " + thirdNum;
    else str = firstNum + " " + op + " " + SecondNum;
    
    correct = eval(str);
    operationDiv.innerHTML = str;

    var arr = [];
    arr.push(correct);

    while(arr.length < 7)
    {
        let fn = getRandomNumber(maxNumber);
        let sn = getRandomNumber(maxNumber);
        let tn = getRandomNumber(maxNumber);
        if(numQuest == 3) if(op == '/' && op2 == '/')
        {
            while (sn == 0 || tn == 0 || eval(fn + " " + op + " " + sn + " " + op2 + " " + tn) % 1 != 0)
            {
                sn = getRandomNumber(maxNumber);
                tn = getRandomNumber(maxNumber);
            }
        }
        if(op == '/')
        {
            while (sn == 0 || fn % sn != 0)
            {
                sn = getRandomNumber(maxNumber);
            }
        }
        if(op2 == '/')
        {
            while(tn == 0 || eval(fn + " " + op + " " + sn + " " + op2 + " " + tn) % 1 != 0)
            {
                tn = getRandomNumber(maxNumber);
            }
        }
        var rand;
        if(numQuest == 3) rand = eval(fn + " " + op + " " + sn + " " + op2 + " " + tn);
        else rand = eval(fn + " " + op + " " + sn)
        
        if (arr.indexOf(rand) === -1) arr.push(rand);
    }

    document.getElementById("btn1").innerHTML = arr[1];
    document.getElementById("btn2").innerHTML = arr[2];
    document.getElementById("btn3").innerHTML = arr[3];
    document.getElementById("btn4").innerHTML = arr[4];

    let correctIndex = Math.floor(Math.random()*4) + 1;
    let correctId = "btn" + correctIndex;
    document.getElementById(correctId).innerHTML = correct;

}

function nextQuestionHard()
{
    let operationDiv = document.getElementById("operation");

    var d = Math.random();
    let numQuest;
    if(d < 0.2) numQuest = 2;
    else if(d < 0.4) numQuest = 3;
    else numQuest = 4;

    let maxNumber = 80;

    let op = getRandomOp();
    let op2;
    let op3;

    if(numQuest >= 3) op2 = getRandomOp();
    if(numQuest == 4) op3 = getRandomOp();

    if (numQuest == 3) if(op == '/' || op2 == '/' || op == '*' || op2 == '*' || op3 == '/' || op3 == '*') maxNumber = 14;
    if (numQuest == 4) if(op == '/' || op2 == '/' || op == '*' || op2 == '*' || op3 == '/' || op3 == '*') maxNumber = 12;

    let firstNum = getRandomNumber(maxNumber);
    let SecondNum = getRandomNumber(maxNumber);
    let thirdNum;
    let fourthNum;

    if(numQuest >= 3) thirdNum = getRandomNumber(maxNumber);
    if(numQuest == 4) fourthNum = getRandomNumber(maxNumber);

    if(numQuest == 4) if(op == '/' && op2 == '/' && op3 == '/')
    {
        while (SecondNum == 0 || thirdNum == 0 || fourthNum == 0 || eval(firstNum + " " + op + 
        " " + SecondNum + " " + op2 + " " + thirdNum + " " + op3 + " " + fourthNum) % 1 != 0)
            {
                SecondNum = getRandomNumber(maxNumber);
                thirdNum = getRandomNumber(maxNumber);
                fourthNum = getRandomNumber(maxNumber);
            }
    }
    if(numQuest >= 3) if(op == '/' && op2 == '/')
    {
        while (SecondNum == 0 || thirdNum == 0 || eval(firstNum + " " + op + 
        " " + SecondNum + " " + op2 + " " + thirdNum + " " + op3 + " " + fourthNum) % 1 != 0)
        {
            SecondNum = getRandomNumber(maxNumber);
            thirdNum = getRandomNumber(maxNumber);
        }
    }
    if(numQuest >= 3) if(op2 == '/' && op3 == '/')
    {
        while (thirdNum == 0 || fourthNum == 0 || eval(firstNum + " " + op + 
        " " + SecondNum + " " + op2 + " " + thirdNum + " " + op3 + " " + fourthNum) % 1 != 0)
        {
            thirdNum = getRandomNumber(maxNumber);
            fourthNum = getRandomNumber(maxNumber);
        }
    }
    if(numQuest >= 3) if(op == '/' && op3 == '/')
    {
        while (SecondNum == 0 || fourthNum == 0 || eval(firstNum + " " + op + 
        " " + SecondNum + " " + op2 + " " + thirdNum + " " + op3 + " " + fourthNum) % 1 != 0)
        {
            SecondNum = getRandomNumber(maxNumber);
            fourthNum = getRandomNumber(maxNumber);
        }
    }
    if(op == '/')
    {
        while (SecondNum == 0 || firstNum % SecondNum != 0)
        {
            SecondNum = getRandomNumber(maxNumber);
        }
    }
    if(op2 == '/')
    {
        while(thirdNum == 0 || SecondNum % thirdNum != 0)
        {
            thirdNum = getRandomNumber(maxNumber);
        }
    }
    if(op3 == '/')
    {
        while(fourthNum == 0 || thirdNum % fourthNum != 0)
        {
            fourthNum = getRandomNumber(maxNumber);
        }
    }

    let str;
    if (numQuest == 3) str = firstNum + " " + op + " " + SecondNum + " " + op2 + " " + thirdNum;
    if (numQuest == 4) str = firstNum + " " + op + " " + SecondNum + " " + op2 + " " + thirdNum + " " + op3 + " " + fourthNum;
    if (numQuest == 2) str = firstNum + " " + op + " " + SecondNum;
    
    correct = eval(str);
    operationDiv.innerHTML = str;

    var arr = [];
    arr.push(correct);

    while(arr.length < 7)
    {
        let fn = getRandomNumber(maxNumber);
        let sn = getRandomNumber(maxNumber);
        let tn = getRandomNumber(maxNumber);
        let fon = getRandomNumber(maxNumber);
        if(numQuest == 4) if(op == '/' && op2 == '/' && op3 == '/')
        {
            while (sn == 0 || tn == 0 || fon == 0 || eval(fn + " " + op + 
            " " + sn + " " + op2 + " " + tn + " " + op3 + " " + fon) % 1 != 0)
                {
                    sn = getRandomNumber(maxNumber);
                    tn = getRandomNumber(maxNumber);
                    fon = getRandomNumber(maxNumber);
                }
        }
        if(numQuest >= 3) if(op == '/' && op2 == '/')
        {
            while (sn == 0 || tn == 0 || eval(fn + " " + op + 
            " " + sn + " " + op2 + " " + tn + " " + op3 + " " + fon) % 1 != 0)
            {
                sn = getRandomNumber(maxNumber);
                tn = getRandomNumber(maxNumber);
            }
        }
        if(numQuest >= 3) if(op2 == '/' && op3 == '/')
        {
            while (tn == 0 || fon == 0 || eval(fn + " " + op + 
            " " + sn + " " + op2 + " " + tn + " " + op3 + " " + fon) % 1 != 0)
            {
                tn = getRandomNumber(maxNumber);
                fon = getRandomNumber(maxNumber);
            }
        }
        if(numQuest >= 3) if(op == '/' && op3 == '/')
        {
            while (sn == 0 || fon == 0 || eval(fn + " " + op + 
            " " + sn + " " + op2 + " " + tn + " " + op3 + " " + fon) % 1 != 0)
            {
                sn = getRandomNumber(maxNumber);
                fon = getRandomNumber(maxNumber);
            }
        }
        if(op == '/')
        {
            while (sn == 0 || fn % sn != 0)
            {
                sn = getRandomNumber(maxNumber);
            }
        }
        if(op2 == '/')
        {
            while(tn == 0 || sn % tn != 0)
            {
                tn = getRandomNumber(maxNumber);
            }
        }
        if(op3 == '/')
        {
            while(fon == 0 || tn % fon != 0)
            {
                fon = getRandomNumber(maxNumber);
            }
        }
        var rand = eval(fn + " " + op + " " + sn);
            if (numQuest == 3) rand = eval(fn + " " + op + " " + sn + " " + op2 + " " + tn);
            if (numQuest == 4) rand = eval(fn + " " + op + " " + sn + " " + op2 + " " + tn + " " + op3 + " " + fon);
            if (arr.indexOf(rand) === -1) arr.push(rand);
        }

    document.getElementById("btn1").innerHTML = arr[1];
    document.getElementById("btn2").innerHTML = arr[2];
    document.getElementById("btn3").innerHTML = arr[3];
    document.getElementById("btn4").innerHTML = arr[4];
    document.getElementById("btn5").innerHTML = arr[5];
    document.getElementById("btn6").innerHTML = arr[6];

    let correctIndex = Math.floor(Math.random()*6) + 1;
    let correctId = "btn" + correctIndex;
    document.getElementById(correctId).innerHTML = correct;

}

function checkAnswer(btnIndex)
{
    let answer = document.getElementById("btn" + btnIndex).innerText;
    let timeToScore = document.getElementById("time").innerText;
    if(answer == correct){
        document.getElementById("scoreDiv").style.color = 'rgb(121, 235, 121)';
        document.getElementById("timeDiv").style.color = 'rgb(121, 235, 121)';
        document.getElementById("question-text").style.color = 'rgb(121, 235, 121)';
        document.getElementById("operation").style.border = '1px solid rgb(121, 235, 121)';
        score += Number(timeToScore);
        if(dif == 'MEDIUM') score += 10;
        if(dif == 'HARD') score += 22;
        document.getElementById("score").innerHTML = score;
        clearInterval(timeCountDown);
        timeLeft = difTime;
        setTimeout(() => {
            document.getElementById("scoreDiv").style.color = 'white';
            document.getElementById("timeDiv").style.color = 'white';
            document.getElementById("question-text").style.color = 'white';
            document.getElementById("operation").style.border = '1px solid white';
            startTimer();
            if(dif == 'EASY') nextQuestionEasy();
            if(dif == 'MEDIUM') nextQuestionMedium();
            if(dif == 'HARD') nextQuestionHard();
        },200)
    }else{
        document.getElementById("scoreDiv").style.color = 'rgb(230, 51, 51)';
        document.getElementById("timeDiv").style.color = 'rgb(230, 51, 51)';
        document.getElementById("question-text").style.color = 'rgb(230, 51, 51)';
        document.getElementById("operation").style.border = '1px solid rgb(230, 51, 51)';
        setTimeout(() => {
            document.getElementById("scoreDiv").style.color = 'white';
            document.getElementById("timeDiv").style.color = 'white';
            document.getElementById("question-text").style.color = 'white';
            document.getElementById("operation").style.border = '1px solid white';
        },200)
        gameOver();
    }

}



window.onload = function() {
	let easy = document.getElementById('easy');
    let normal = document.getElementById('normal');
    let hard = document.getElementById('hard');
	let overlays = Array.from(document.getElementsByClassName('overlay-text'));
	let main_overlay = document.getElementById('main_overlay');

	easy.addEventListener('click', () => { 
		document.getElementById("gameDif").value = "EASY";
        document.getElementById("time").innerHTML = '10';
        difTime = 10;
        dif = 'EASY';
        overlays.forEach(overlay => {
                overlay.classList.remove('visible');
        });
        startGame();
    });

	normal.addEventListener('click', () => {
		document.getElementById("gameDif").value = "MEDIUM";
        document.getElementById("time").innerHTML = '6';
        difTime = 6;
        dif = 'MEDIUM';
        overlays.forEach(overlay => {
                overlay.classList.remove('visible');
        });

        startGame();
    });

	hard.addEventListener('click', () => { 
		document.getElementById("gameDif").value = "HARD";
        document.getElementById("time").innerHTML = '8';
        difTime = 8;
        dif = 'HARD';
        overlays.forEach(overlay => {
                overlay.classList.remove('visible');
        });

        startGame();
    });

	

}

const hide = setInterval(function() {
    document.getElementById("scoreInput").style.display = "none";
    document.getElementById("scoreInput").value = score;
    document.getElementById("gameInput").style.display = "none";
    document.getElementById("gameDif").style.display = "none";
    document.getElementById("gameTime").style.display = "none";
}, 1000);
