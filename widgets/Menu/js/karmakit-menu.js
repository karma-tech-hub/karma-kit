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
