document.getElementById("amount").addEventListener("change", function() {
    let amount = this.value;
    let computation = document.getElementById("computation");
  
    if (amount === "3000") {
      computation.value = "3 months";
    } else if (amount === "6000") {
      computation.value = "4 months";
    } else if (amount === "10000") {
      computation.value = "6 months";
    } else if (amount === "20000") {
      computation.value = "9 months";
    } else {
      computation.value = "";
    }
  });  