var dateControl = document.querySelector('input[type="date"]');
dateControl.value = "2017-06-01";
console.log(dateControl.value); // imprime "2017-06-01"
console.log(dateControl.valueAsNumber); // imprime 1496275200000, una marca de fecha (en ms) en JavaScript.