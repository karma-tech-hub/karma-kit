/**
 * @project        Karma Kit
 * @author         Karma Team
 * @website        https://karamtechhub.com
 * @version       1.0.0
 *
 */

if (document.querySelector("#karmakit-nav-res-area input")) {
    document.querySelector("#karmakit-nav-res-area input").addEventListener("click", () => {
        if (document.querySelector('#karmakit-nav-res-area input').checked) {
            document.querySelector('body').style.overflow = 'hidden';
        } else {
            document.querySelector('body').style.overflow = 'initial';
        }
    })
}

function getPosition(element) {
    var xPosition = 0;
    var yPosition = 0;

    while (element) {
        xPosition += (element.offsetLeft - element.scrollLeft + element.clientLeft);
        yPosition += (element.offsetTop - element.scrollTop + element.clientTop);
        element = element.offsetParent;
    }
    return {
        x: xPosition,
        y: yPosition
    };
}


var ww = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
var pos = getPosition(document.getElementById('karmakit-nav-res'));

if (pos.x > (ww / 2)) {
    document.getElementById('karmakit-nav-res').style.marginLeft = '-130px';
}
