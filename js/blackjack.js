/**
 * Created by Øyvind on 07.07.2015.
 */
function cripple(){
    //Prevents spam click on start and play again button
    if(document.getElementById('again')){
        document.getElementById('again').type = 'button';
    }
    else if(document.getElementById('start')){
        document.getElementById('start').type = 'button';
    }
}