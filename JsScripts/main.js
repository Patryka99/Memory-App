const menuBtn = document.querySelector('.bt-menu');
const sideMenu = document.querySelector('.side-menu');

const registerBtn = document.querySelector('.open-register');
const loginBtn2 = document.querySelector('.open-login');
const registerPopup = document.querySelector('.register-popup');
const registerClose = document.querySelector('.register-close');

const loginBtn = document.querySelector('.logIn');
const loginPopup = document.querySelector('.login-popup');
const loginClose = document.querySelector('.login-close');

const registerFromLogin = document.querySelector('.Register');

const menuLogin = document.querySelector('.menu-login');
const menuRegister = document.querySelector('.menu-register');

const datePicker = document.getElementById("date");

let loginOpen = false;
let registerOpen = false;


let menuOpen = false;

function ready()
{
    if( datePicker != null && date != null)
    {
        datePicker.min = getDate(36500);
        datePicker.max = getDate(1100);
    }

    function getDate(days) {
        let date;

        if (days !== undefined) {
            date = new Date(Date.now() - days * 24 * 60 * 60 * 1000);
        } else {
            date = new Date();
        }

        const offset = date.getTimezoneOffset();

        date = new Date(date.getTime() - (offset*60*1000));

        return date.toISOString().split("T")[0];
    }
    
    if(menuLogin != null){
        menuLogin.addEventListener('click', () =>{
            if(!loginPopup.classList.contains("active") && !registerPopup.classList.contains("active")){
                loginPopup.classList.add('active');
                loginOpen = true;
            }else if (!loginPopup.classList.contains("active") && registerPopup.classList.contains("active")){
                registerPopup.classList.remove('active');
                registerOpen = false;
                
                loginPopup.classList.add('active');
                loginOpen = true;
            }else {
                loginPopup.classList.remove('active');
                loginOpen = false;
            }
        })
    }
    
    
    if(menuRegister != null){
        menuRegister.addEventListener('click', () => {
            if(!registerOpen && !loginOpen){
                registerPopup.classList.add('active');
                registerOpen = true;
            }else if(!registerOpen && loginOpen){
                loginPopup.classList.remove('active');
                loginOpen = false;
                registerPopup.classList.add('active');
                registerOpen = true;
        
            }else {
                registerPopup.classList.remove('active');
                registerOpen = false;
            }
        })
    }

    if(menuBtn != null && sideMenu !=null)
    {
        menuBtn.addEventListener('click', () => {
            if(!menuOpen){
                menuBtn.classList.add('open');
                sideMenu.classList.add('open');
                menuOpen = true;
            }else {
                menuBtn.classList.remove('open');
                sideMenu.classList.remove('open');
                menuOpen = false;
            }
        });
    }
    
    if(registerBtn != null){
        registerBtn.addEventListener('click', () => {
            if(!registerOpen && !loginOpen){
                registerPopup.classList.add('active');
                registerOpen = true;
            }else if(!registerOpen && loginOpen){
                loginPopup.classList.remove('active');
                loginOpen = false;
                registerPopup.classList.add('active');
                registerOpen = true;
        
            }else if(!loginOpen && registerOpen){
                registerPopup.classList.remove('active');
                registerOpen = false;
            }
        })
    }

    if(loginBtn2 != null){
        loginBtn2.addEventListener('click', () => {
            if(!registerOpen && !loginOpen){
                loginPopup.classList.add('active');
                loginOpen = true;
            }else if(registerOpen && !loginOpen){
                registerPopup.classList.remove('active');
                registerOpen = false;
                loginPopup.classList.add('active');
                loginOpen = true;
        
            }else if(loginOpen){
                loginPopup.classList.remove('active');
                loginOpen = false;
            }
        })
    }
    
    if(registerClose != null)
    {
        registerClose.addEventListener('click', () => {
            registerPopup.classList.remove('active');
            registerOpen = false;
        })
    }

    if(loginClose != null)
    {
        loginClose.addEventListener('click', () => {
            loginPopup.classList.remove('active');
            loginOpen = false;
        })
    }
    
    if(loginBtn != null)
    {
        loginBtn.addEventListener('click', () =>{
            if(!loginPopup.classList.contains("active") && !registerPopup.classList.contains("active")){
                loginPopup.classList.add('active');
                loginOpen = true;
            }else if (!loginPopup.classList.contains("active") && registerPopup.classList.contains("active")){
                registerPopup.classList.remove('active');
                registerOpen = false;
                
                loginPopup.classList.add('active');
                loginOpen = true;
            }else {
                loginPopup.classList.remove('active');
                loginOpen = false;
            }
        })
    }

    if(registerFromLogin != null)
    {
        registerFromLogin.addEventListener('click', () => {
            loginPopup.classList.remove('active');
            loginOpen = false;
        
            registerPopup.classList.add('active');
            registerOpen = true;
        })
    }
}

const para = document.querySelector(".main-paralax");

if(para != null)
{
    para.addEventListener("mousemove", parallax);

    function parallax(e){
        this.querySelectorAll(".paralax").forEach(paralax => {
            const speed = paralax.getAttribute('data-speed')
    
            const x = (window.innerWidth - e.pageX*speed)/100
            const y = (window.innerWidth - e.pageY*speed)/100
    
            paralax.style.transform = 'translateX('+x+'px) translateY('+y+'px)'
        });
    }
}

if(document.readyState === 'loading') {
    console.log('loading');
    document.addEventListener('DOMContentLoaded', ready());
}else {
    console.log('ready');
    ready();
}