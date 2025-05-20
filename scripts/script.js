function openDiallerClient() {
    var telNumber = '35688330000';
    window.location.href = 'tel:' + telNumber;
}

function openEmailClient() {
    location.href = 'mailto:laffrescoassignment@gmail.com';
}

/**
 * Shows or hides a form based on a check button.
 * 
 * @param {*} nameForm Name of the form.
 */
function showExtraForm(nameForm) {

    // Store whether the check button is checked or not.
    var checked = document.getElementById(nameForm).checked;

    if (checked) {
        /*  
            If the check button is checked,
            The display attribute of the form is set to flex.
            And the attribute required is added.
        */
        document.getElementById("extra-" + nameForm).style.display = "flex";
        document.getElementById("amount-" + nameForm).setAttribute('required', 'true');

    } else {
        /*  
            If the check button is not checked,
            The display attribute of the form is set to none, therefore the form is hidden.
            And the attribute required is removed.
        */
        document.getElementById("extra-" + nameForm).style.display = "none";
        document.getElementById("amount-" + nameForm).removeAttribute('required');
    }
}