let video = document.querySelector('video');
let textPrimary = document.getElementById('word-change');
const intersectionObserver = new IntersectionObserver(async (entries) => {
    if (entries[0].intersectionRatio <= 0) {
        await video.play();
    } else {
        video.pause();
    }
}, {
    threshold: .5
});
// start observing
intersectionObserver.observe(video);


let wordsIndex = 0;
let words = ['excelência', 'Orgulho', 'Integridade', 'Honestidade']

setInterval(() => {
    wordsIndex++;
    if (wordsIndex >= 4) {
        wordsIndex = 0;
    }
    textPrimary.innerHTML = words[wordsIndex]
}, 3000)