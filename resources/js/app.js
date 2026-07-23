import './bootstrap';
import './echo';

window.Echo.channel('janken')
    .listen('.HandPlayed', (e) => {

        document.getElementById('result').innerHTML =
            e.player + ' が出した手: ' + e.hand;

    });