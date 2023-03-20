class AudioController {
    constructor(){
        this.blinkSound = new Audio('../Audio/Flip.wav');
        this.blinkSound2 = new Audio('../Audio/Match.wav');
        this.victorySound = new Audio('../Audio/Victory.wav');
        this.gameOverSound = new Audio('../Audio/Game-Over.wav');
    }

    blink() {
        this.blinkSound.play();
    }
    blink2() {
        this.blinkSound2.play();
    }
    victory() {
        this.victorySound.play();
    }
    gameover() {
        this.gameOverSound.play();
    }

}

class SimonSays {
    constructor(plates, lighters){
        this.platesArray = plates;
        this.lightersArray = lighters;
        this.counter = document.getElementById('counter');
        this.score = document.getElementById('score');
        this.audioController = new AudioController();
        this.on = true;
    }
    
    startGame(){
        this.order = [];
        this.playerOrder = [];
        this.flash = 0;
        this.intervalId = 0;
        this.win = false;
        this.turn = 1;
        this.counter.innerHTML = 1;
        this.score.innerHTML = 0;
        this.good = true;
        this.compTurn = true;
        
        for(let i = 0; i < 100; i++){
            this.order.push(Math.floor(Math.random() * 9) +1 );
        }
        console.log(this.order);
        
        this.intervalId = setInterval(this.gameTurn.bind(this) , 800);
    }
    
    gameTurn(){
        this.on = false;
        
        if(this.flash == this.turn){
            clearInterval(this.intervalId);
            this.compTurn = false;
            this.clearColors();
            this.on = true;
        }
        
        if(this.compTurn){
            this.clearColors();
            setTimeout(() => {
                this.audioController.blink();
                this.lightUp(this.order[this.flash]);
                this.flash++;
            }, 200);
        }
    }
    
    lightUp(i){
        this.platesArray.forEach(plate => {
            if(this.getPlateData(plate) == i){
                plate.getElementsByClassName('lighter')[0].classList.add('light');
            } 
        });
    }
    
    clearColors(){
            this.lightersArray.forEach(l => {
                l.classList.remove('light');
            });
    }
    
    flashColors(){
        this.lightersArray.forEach(l => {
            l.classList.add('light');
        });
    }
    
    
    getPlateData(plate){
        return plate.getElementsByClassName('lighter')[0].getAttribute('data-value');
    }
    
    checkIfGood(){
        
        if(this.playerOrder[this.playerOrder.length - 1] != this.order[this.playerOrder.length -1]){
            this.good = false;
            this.flashColors();
            this.audioController.gameover();
            document.getElementById('over-txt').classList.add('visible');
            document.getElementById('endScore').innerHTML = parseInt(this.score.textContent);
            document.getElementById("scoreInput").value = parseInt(this.score.textContent);

            setTimeout(() => {
                this.clearColors(); 
            }, 800);
        }
        
        if(this.playerOrder.length == 100 && this.good){
            this.victory();
        }
        
        if(this.turn == this.playerOrder.length && this.good && !this.win){
            this.turn ++;
            this.playerOrder = [];
            this.compTurn = true;
            this.flash = 0;
            this.counter.innerHTML = this.turn;
            this.score.innerHTML = parseInt(this.score.textContent) + (this.turn-1)*10;
            this.intervalId = setInterval(this.gameTurn.bind(this) , 800);
        }   
        
        
    }
    
    victory(){
        this.flashColors();
        this.audioController.victory();
        document.getElementById('victory-txt').classList.add('visible');
        this.on = false;
        this.win = true;
        document.getElementById('endScore').innerHTML = this.score;
        if(this.score <= 0)
        {
            document.getElementById("lb").style.display = 'none';
        }
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
    let overlay = document.getElementById('main_overlay');
    let plates = Array.from(document.getElementsByClassName('plate'));
    let lighters = Array.from(document.getElementsByClassName('lighter'));
    let game = new SimonSays(plates,lighters);

    game.startGame();

    overlay.addEventListener('click', () => {
        overlay.classList.remove('visible');
    });


    plates.forEach(plate => {
        plate.addEventListener('click', () => {
            if(game.on){
                game.audioController.blink2();
                game.playerOrder.push(game.getPlateData(plate));
                game.checkIfGood();
                game.lightUp(game.getPlateData(plate));
                if(!game.win){
                    setTimeout(() => {
                        game.clearColors(); 
                    }, 300);
                }
            }
        });
    });


}

const hide = setInterval(function() {
    document.getElementById("scoreInput").style.display = "none";
    document.getElementById("gameInput").style.display = "none";
    document.getElementById("gameDif").style.display = "none";
}, 1000);
