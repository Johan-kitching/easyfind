// set initial color scheme
let explicitelyPreferScheme = false
if (window.localStorage) {
    if (localStorage.getItem('color-theme') === 'dark') {
        document.documentElement.classList.add('dark')
        explicitelyPreferScheme = 'dark'
    } else if (localStorage.getItem('color-theme') === 'light') {
        document.documentElement.classList.remove('dark')
        explicitelyPreferScheme = 'light'
    }
}

if (explicitelyPreferScheme !== 'light' && window.matchMedia('(prefers-color-scheme:dark)').matches) {
    document.documentElement.classList.add('light');
}

export function loadScript(url, callback) {
    // Adding the script tag to the head as suggested before
    var head = document.head;
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = url;

    // Then bind the event to the callback function.
    // There are several events for cross browser compatibility.
    script.onreadystatechange = callback;
    script.onload = callback;

    // Fire the loading
    head.appendChild(script);
}

export function toggleFullScreen() {
    if ((document.fullScreenElement && document.fullScreenElement !== null) ||
        (!document.mozFullScreen && !document.webkitIsFullScreen)) {
        if (document.documentElement.requestFullScreen) {
            document.documentElement.requestFullScreen();
        } else if (document.documentElement.mozRequestFullScreen) {
            document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullScreen) {
            document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
        }
    } else {
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        }
    }
}

export function insertPlaceholder(e, name) {
    let quil_editor = Quill.find(document.getElementById(name));
    let mergeFieldText = e;
    var selection = quil_editor.getSelection(true);
    quil_editor.insertText(selection.index, mergeFieldText);
}

export function insertEmbed(e) {
    let mergeImage = e;
    var selection = window.quill.getSelection(true);
    window.quill.insertEmbed(selection.index, 'image', mergeImage);
}

export function toggleText(id) {
    var dots = document.getElementById("dots_" + id);
    var moreText = document.getElementById("more_" + id);
    var btnText = document.getElementById("readMoreBtn_" + id);
    var minText = document.getElementById("minText_" + id);

    if (dots.style.display === "none") {
        dots.style.display = "inline";
        if (typeof(minText) != 'undefined' && minText != null) {
            minText.style.display = "inline";
        }
        btnText.innerHTML = "Meer/More";
        moreText.style.display = "none";
    } else {
        dots.style.display = "none";
        if (typeof(minText) != 'undefined' && minText != null) {
            minText.style.display = "none";
        }
        btnText.innerHTML = "Minder/Less";
        moreText.style.display = "inline";
    }
}
