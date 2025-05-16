/**
 * YOUR CODE GOES HERE
 */

let demoContainer = document.getElementById('demo');
let boxWrapper = document.querySelector('.box:nth-child(1)');

let animationId;
let setted = false;
let marginLeft = 0;

function positionMouse(ev) {
    let x = ev.x;
    let y = ev.y;
    if (ev.x > 300) {
        if (setted !== 'direito') {
            moveContainer('direito')
        }
    } else {
        if (setted !== 'esquerdo') {
            moveContainer('esquerdo');
        }
    }
}

function moveContainer(side) {
    setted = side;
    side = side === 'direito' ? -2 : 2;
    clearInterval(animationId)
    animationId = setInterval(() => {
        marginLeft += side;
        if (Math.abs(marginLeft) > 2300) {
            marginLeft = -2300
        }
        if(marginLeft > 10){
            marginLeft = 10;
        }
        boxWrapper.style.marginLeft = marginLeft + 'px';
    }, 1)
}

demoContainer.addEventListener('mouseenter', positionMouse)
demoContainer.addEventListener('mousemove', positionMouse)
demoContainer.addEventListener('mouseout', () => {
    clearInterval(animationId)
    setted = 'nenhum'
})