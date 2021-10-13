  function sendJSON() {
    let startDate = document.querySelector('#startDate');
    let sum = document.querySelector('#sum');
    let term = document.querySelector('#term');
    let terms = document.querySelector('#terms');
    let termValue;
    if (terms.value == "year") termValue = term.value * 12;
    else termValue = term.value;
    let percent = document.querySelector('#percent');
    let sumAdd = document.querySelector('#sumAdd');
    let isSumAdd = document.querySelector('#isSumAdd');
    if (isSumAdd.checked != true) sumAdd.value = 0;
    let result = document.querySelector('.result');
    let xhr = new XMLHttpRequest();
    let url = "calc.php";
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = function () {
        result.innerHTML = this.responseText;
    };
    var data = JSON.stringify({ "startDate": startDate.value, "sum": sum.value, "term": termValue, "percent": percent.value, "sumAdd": sumAdd.value });
    xhr.send(data);
  }

  function checkAdd(){
    var checkbox = document.getElementById('isSumAdd');
  if (checkbox.checked != true){
    $("#sumAdd").hide();
}
else $("#sumAdd").show();

}
