var words = ['Hi, I`m Patryk Arendt, nice to meet you.', 'I`m made this project as a part of engineering thesis.',
'You can test here your memory by playing games on this site.','Right now i`m studying IT.', 'Hope You like what You see :)'],
    part,
    i = 0,
    offset = 0,
    len = words.length,
    forwards = true,
    skip_count = 0,
    skip_delay = 15,
    speed = 70;

    var wordflick = function () {
        setInterval(function () {
        if (forwards) {
            if (offset >= words[i].length) {
            ++skip_count;
            if (skip_count == skip_delay) {
                forwards = false;
                skip_count = 0;
            }
            }
        }
        else {
            if (offset == 0) {
            forwards = true;
            i++;
            offset = 0;
            if (i >= len) {
                i = 0;
            }
            }
        }
        part = words[i].substr(0, offset);
        if (skip_count == 0) {
            if (forwards) {
            offset++;
            }
            else {
            offset--;
            }
        }
        $('.typeWord').text(part);
        },speed);
    };
    
    if(document.readyState === 'loading') {
        console.log('loading');
        document.addEventListener('DOMContentLoaded', wordflick());
    }else {
        console.log('ready');
        wordflick();
    }