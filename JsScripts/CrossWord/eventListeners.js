window.addEventListener('load', ()=>{
    while(data.length!=10){
        placeResults();
    }

    body.style.filter = 'blur(0px)';
    body.style.backdropFilter = 'blur(0px)';
})

document.addEventListener('click', async ()=>{
    if(!gameStarted){
        gameStarted = true;
        await new Promise(resolve => setTimeout(resolve, 500));
        inputString.innerHTML = '';
        triggerCountdown();
        document.querySelectorAll('.alphabetic-key span').forEach(elem => elem.style.opacity = '1');
        keysAllowed = true;
    }
})

document.addEventListener('keydown', async (e)=>{
    if(keysAllowed && sample.includes(e.key.toLocaleLowerCase()) && inputString.innerHTML.length!=6 && !e.repeat){
        inputString.innerHTML = inputString.innerHTML + e.key.toUpperCase();
        alphaKeys[sample.indexOf(e.key.toLowerCase())].querySelector('img').style.filter = 'brightness(50%)';
        new Audio('../Audio/Crossword/keyPress.mp3').play();
    }
    else if(e.key=='Backspace' && keysAllowed && inputString.innerHTML.length>0 && !e.repeat){
        inputString.innerHTML = inputString.innerHTML.slice(0,inputString.innerHTML.length-1);
        backspaceKeyImg.style.filter = 'brightness(50%)';
        new Audio('../Audio/Crossword/backspace.mp3').play();
    }
    else if(e.key=='Escape' && keysAllowed){
        gameOver();
    }
    else if(keysAllowed && e.code=='Space' && !e.repeat && inputString.innerHTML.length>=3){
        spaceKeyImg.style.filter = 'brightness(50%)';
        let correct = false;

        data.forEach((object)=>{
            if(object.result == inputString.innerHTML.toLowerCase() && !solved.includes(inputString.innerHTML.toLowerCase())){
                correct = true;
                new Audio('../Audio/Crossword/correct.mp3').play();
                scoreValue.innerHTML = Number(scoreValue.innerHTML) + (object.result.length*10);
                scoreText.style.color = 'lime';
                scoreText.animate(
                    [{color:'lime'}, {color:'white'}],
                    {duration: 3000, easing: 'linear', fill: 'forwards'}
                );

                object.occupied.forEach((cellNo)=>{
                    let blocksArray = getBlocksAtCellNo(cellNo);
                    if(blocksArray.length==1){
                        blocksArray[0].style.transform = 'scale(1)';
                    }
                    else if(blocksArray.length==2){
                        if(blocksArray[0].style.transform == 'scale(0)'){
                            blocksArray[0].style.transform = 'scale(1)';
                        }
                        else{
                            blocksArray[1].style.transform = 'scale(1)';
                        }
                    }
                })
                solved.push(object.result);

                if(solved.length==10){
                    new Audio('../Audio/Crossword/win.mp3').play();
                    clearInterval(countdownID);
                    scoreValue.innerHTML = Number(scoreValue.innerHTML) + Number(countdown.innerHTML) + 1000;
                }
            }
        })
        !correct && new Audio('../Audio/Crossword/wrong.mp3').play();
        inputString.innerHTML = '';
    }
    else if (e.key=='Enter' && keysAllowed && (solved.length==10 || skips!= 3)){
        solved.length!=10 && skips++;
        solved = [];
        inputString.innerHTML = '';
        clearInterval(countdownID);
        keysAllowed = false;
        body.style.filter = 'blur(200px)';
        body.style.backdropFilter = 'blur(200px)';
        await new Promise(resolve => setTimeout(resolve, 500))

        data = [];
        while(data.length!= 10){
            placeResults();
        }

        body.style.filter = 'blur(0px)';
        body.style.backdropFilter = 'blur(0px)';
        await new Promise(resolve => setTimeout(resolve, 500));

        triggerCountdown();
        keysAllowed = true;

        console.log(skips);
        document.getElementById("skipLeft").innerHTML = 3-skips;
    }
})

document.addEventListener('keyup',(e)=>{
    if(keysAllowed && sample.includes(e.key.toLowerCase())){
        setTimeout(() => {
            alphaKeys[sample.indexOf(e.key.toLowerCase())].querySelector('img').style.filter = 'brightness(100%)';
        },100)
    }
    else if(keysAllowed && e.code =='Space'){
        setTimeout(() => {
            spaceKeyImg.style.filter = 'brightness(100%)';
        },100)
    }
    else if(keysAllowed && e.key=='Backspace'){
        setTimeout(() => {
            backspaceKeyImg.style.filter = 'brightness(100%)';
        },100)
    }
})