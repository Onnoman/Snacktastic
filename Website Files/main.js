function load() {
    document.getElementById("agenda").scrollTo(0,400);
}

function agendaAdd(i, j) {
    document.getElementById("addAgenda").style.visibility = 'visible';
    var day = "";
    if(j == 0)
    {
        day = "Monday";
    } else if(j == 1)
    {
        day = "Tuesday"
    } else if(j == 2)
    {
        day = "Wednesday"
    } else if(j == 3)
    {
        day = "Thursday"
    } else if(j == 4)
    {
        day = "Friday"
    } else if(j == 5)
    {
        day = "Saturday"
    } else if(j == 6)
    {
        day = "Sunday"
    }
    document.getElementById("addAgenda").innerHTML = `
    <div class="cross" onclick="stopAgenda()">×</div>
    <form method="post" action="agendaProcessing.php">` + day + ` at ` + i + 
    `:<input type="number" id="minutes" name="minutes" min="0" max="59" value="0"><br>
    Buzzer melody 
    <select name="buzzMelody">
        <option selected value="1" label="Melody 1"></option>
        <option value="2" label="Melody 2"></option>
        <option value="3" label="Melody 3"></option>
        <option value="4" label="Melody 4"></option>
    </select>
    LED color <input type="color" name="ledColor" value="#FFFF00"><br>
    <input type="submit" value="Add to agenda">
    <input type="hidden" id="hour" name="hour" value="` + i + `">
    <input type="hidden" id="day" name="day" value="` + j + `">
    </form>
    `;
}

function stopAgenda() {
    document.getElementById("addAgenda").style.visibility = 'hidden';
}

function agendaUpdate(Snack_ID) {
    alert(Snack_ID);
}

function extraInfo(i) {
    document.getElementById(i).style.visibility = "visible";
}

function stopExtraInfo(i) {
    document.getElementById(i).style.visibility = "hidden";
}

function changePass() {
    document.getElementById('changePass').style.visibility = "visible";
}

function stopPass() {
    document.getElementById('changePass').style.visibility = "hidden";
}

function addSnackbox() {
    document.getElementById('addSnackbox').style.visibility = "visible";
}

function stopSnack() {
    document.getElementById('addSnackbox').style.visibility = "hidden";
}