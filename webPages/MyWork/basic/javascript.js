// Friendly non-blocking welcome message and dynamic year
(function(){
    var welcome = document.getElementById('welcome');
    if(welcome){
        welcome.textContent = 'Welcome to Sigma Web Development!';
    }
    var yearEl = document.getElementById('year');
    if(yearEl){
        yearEl.textContent = new Date().getFullYear();
    }
})();