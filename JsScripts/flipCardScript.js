let ValScore = 0;

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

class FlipCards {
    constructor(totalTime, cards){
        this.cardsArray = cards;
        this.totalTime = totalTime;
        this.timeReaming = totalTime;
        this.timer = document.getElementById('time');
        this.ticker = document.getElementById('flips');
        this.audioController = new AudioController();
    }
    
    startGame(diff) {
        this.cardToCheck = null;
        this.totalClicks = 0;
        this.timeReaming = this.totalTime;
        this.matchedCards = [];
        this.busy = true;
        this.diff = diff;
        
        setTimeout(() => {
            this.shuffle();
            this.countDown = this.startCountDown();
            this.busy = false;
        }, 500);
        this.hideCards();
        this.timer.innerText = this.timeReaming;
        this.ticker.innerText = this.totalClicks;
    }
    
    flipCard(card) {
        if(this.canFlipCard(card)) {
            this.audioController.flip();
            this.totalClicks++;
            this.ticker.innerText = this.totalClicks;
            card.classList.add('visible');

            if(this.cardToCheck) {
                this.checkForMatch(card);
            } else {
                this.cardToCheck = card;
            }
        }
    }
    
    checkForMatch(card){
        if(this.getCardType(card) === this.getCardType(this.cardToCheck)){
            this.cardMatch(card, this.cardToCheck);
        }else{
            this.dontMatch(card, this.cardToCheck);
        }
        
        this.cardToCheck = null;
    }
    
    cardMatch(card1, card2){
        this.matchedCards.push(card1);
        this.matchedCards.push(card2);
        card1.classList.add('matched');
        card2.classList.add('matched');
        this.audioController.match();
        if(this.matchedCards.length === this.cardsArray.length){
            this.victory();
        }
    }
    
    dontMatch(card1, card2){
        this.busy = true;
        setTimeout(() => {
            card1.classList.remove('visible');
            card2.classList.remove('visible');
            this.busy = false;
        }, 1000)
    }
    
    getCardType(card){
        return card.getElementsByClassName('value-card')[0].src;
    }
    
    canFlipCard(card){
        return (!this.busy && !this.matchedCards.includes(card) && card !== this.cardToCheck);
    }
    
    shuffle(){
        let i =0;
        for(i = this.cardsArray.length - 1; i > 0; i--){
            let randIndex = Math.floor(Math.random() * (i+1));
            this.cardsArray[randIndex].style.order = 1;
            this.cardsArray[i].style.order = randIndex;
        }
    }
    
    hideCards(){
        this.cardsArray.forEach(card => {
            card.classList.remove('visible');
            card.classList.remove('matched');
        });
    }
    startCountDown(){
        return setInterval(() => {
            this.timeReaming--;
            this.timer.innerText = this.timeReaming;
            if(this.timeReaming === 0){
                this.gameOver();
            }
        },1000);
    }
    
    gameOver() {
        var score = 0;
        clearInterval(this.countDown);
        this.audioController.gameover();
        document.getElementById('over-txt').classList.add('visible');
        this.hideCards();
        
        document.getElementById('endScore').innerHTML = score;
        if(score <= 0)
        {
            document.getElementById("lb").style.display = 'none';
        }
    }
    
    victory(){
        var score = 0;
        if (this.diff == 'easy') score += 200;
        else if(this.diff == 'medium') score += 900;
        else if(this.diff == 'hard') score =+ 1500;

        score += (this.timeReaming*10);
        score -= (this.totalClicks*3);
        clearInterval(this.countDown);
        this.audioController.victory();
        document.getElementById('victory-txt').classList.add('visible');

        document.getElementById('endScore').innerHTML = score;

        document.getElementById("scoreInput").value = score;
        ValScore = score;
    }
    
    
    
}

if(document.readyState === 'loading') {
    console.log('loading');
    document.addEventListener('DOMContentLoaded', ready());
}else {
    console.log('ready');
    ready();
}

function ready(){
    let main_overlay = document.getElementById('main_overlay');
    let dif_time = 0;
    let overlays = Array.from(document.getElementsByClassName('overlay-text'));
    let cards = Array.from(document.getElementsByClassName('card'));
    let normal_card = Array.from(document.getElementsByClassName('card-normal'));
    let hard_card = Array.from(document.getElementsByClassName('card-hard'));
    let easy = document.getElementById('easy');
    let normal = document.getElementById('normal');
    let hard = document.getElementById('hard');
    let game;
    
    let normal_cards = cards.concat(normal_card);
    let hard_cards = normal_cards.concat(hard_card);

    easy.addEventListener('click', () => {
        dif_time = 50;  
        game = new FlipCards(dif_time, cards); 
        document.getElementById("gameDif").value = "EASY";
        overlays.forEach(overlay => {
                overlay.classList.remove('visible');
        });
        normal_card.forEach(card => {
            card.style.display = "none"
        })
        hard_card.forEach(card => {
            card.style.display = "none"
        })

        game.startGame('easy');
    });

    normal.addEventListener('click', () => {
        dif_time = 60;   
        game = new FlipCards(dif_time, normal_cards);
        document.getElementById("gameDif").value = "MEDIUM";
        overlays.forEach(overlay => {
                overlay.classList.remove('visible');
        });

        hard_card.forEach(card => {
            card.style.display = "none"
        })

        normal_cards.forEach(card => {
            card.style.display = "block"
        })
        

        game.startGame('medium');
    });

    hard.addEventListener('click', () => {
        dif_time = 90;   
        game = new FlipCards(dif_time, hard_cards);
        document.getElementById("gameDif").value = "HARD";
        overlays.forEach(overlay => {
                overlay.classList.remove('visible');
        });

        hard_card.forEach(card => {
            card.style.display = "block"
        })

        normal_cards.forEach(card => {
            card.style.display = "block"
        })

        game.startGame('hard');
    });

    document.getElementById('victory-txt').addEventListener('click', () => { 
        document.getElementById('victory-txt').classList.remove('visible');
        main_overlay.classList.add('visible');
    });
    
    document.getElementById('over-txt').addEventListener('click', () => { 
        document.getElementById('over-txt').classList.remove('visible');
        main_overlay.classList.add('visible');
    });
    

    
    


    cards.forEach(card => {
        card.addEventListener('click', () => {
            game.flipCard(card);    
        });
    });

    normal_card.forEach(card => {
        card.addEventListener('click', () => {
            game.flipCard(card);    
        });
    });

    hard_card.forEach(card => {
        card.addEventListener('click', () => {
            game.flipCard(card);    
        });
    });
    
}

function VictoryNewGame()
{
    document.getElementById('victory-txt').classList.remove('visible');
    main_overlay.classList.add('visible');
}

const hide = setInterval(function() {
    document.getElementById("scoreInput").style.display = "none";
    document.getElementById("scoreInput").value = ValScore;
    document.getElementById("gameInput").style.display = "none";
    document.getElementById("gameDif").style.display = "none";
    document.getElementById("gameTime").style.display = "none";
}, 1000);
