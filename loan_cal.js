

var pettycash;
var bonanzaLoan;
var MPL;



var sf = 0.02;
var Pinterest = 0.02;
var Binterest = 0.02;
var Minterest = 0.03;


let input = prompt ("1. Petty Cash Loan \n 2. Bonanza Loan \n 3. MPL Loan\nPlease choose loan type:");



switch (input) {
  case 1:
    var input2 = prompt ("\n1. PHP 3,000 3 months to pay \n2. PHP 5,000 5 months to pay \n3. PHP 10,000 10 months to pay\nChoose loanable amount: ");
  if(input2=="1"){
    interestR = Pinterest * 3;//0.02 x 3 = 0.06
    serviceF = 3000 * sf; //3000 * 0.02 = 60
    mf = interestR * 3000 //0.06 x 3000 = 180
    Rinterest = serviceF + mf; //60 + 180 = 240
    total1 = 3000 - Rinterest; //3000 - 240 = 2760
    total2 = 3000 - total1; //3000 - 2760 = 240
    
    console.log("\n=================\nService fee:"+serviceF+"\n Monthly fee:"+mf+"\nAmount to receive:"+total1+"\n=================");
    break;
}
}


