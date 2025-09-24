// loan_logic.js

// PETTY CASH (deduct service fee + advance interest upfront)
function calculatePettyCash(amount, months, serviceFeeRate, monthlyInterestRate) {
    // ensure numeric
    amount = parseFloat(amount);
    months = parseInt(months, 10);
    serviceFeeRate = parseFloat(serviceFeeRate);
    monthlyInterestRate = parseFloat(monthlyInterestRate);

    // advance interest = monthly interest × months (TOTAL interest charged up front)
    let advanceInterest = amount * monthlyInterestRate * months; // ₱180 for 3 months

    // one-time service fee
    let serviceFee = amount * serviceFeeRate; // ₱60

    // total deductions
    let totalDeduction = serviceFee + advanceInterest; // ₱240

    // borrower gets this much cash
    let netProceeds = amount - totalDeduction; // ₱2760

    // borrower repays netProceeds in equal installments
    let monthlyPayment = netProceeds / months; // ₱920

    return {
        loanType: "Petty Cash",
        amount: amount,
        months: months,
        serviceFee: serviceFee,
        advanceInterest: advanceInterest,
        totalDeduction: totalDeduction,
        netProceeds: netProceeds,
        monthlyPayment: monthlyPayment
    };
}


// BONANZA (flat / as you specified)
function calculateBonanza(amount, months, interestRatePercent, serviceFeeRatePercent, retentionRatePercent) {
    // ensure numeric
    amount = parseFloat(amount);
    months = parseInt(months, 10);
    let interestRate = parseFloat(interestRatePercent) / 100;
    let serviceFeeRate = parseFloat(serviceFeeRatePercent) / 100;
    let retentionRate = parseFloat(retentionRatePercent || 0) / 100;

    let serviceFee = amount * serviceFeeRate;
    let retentionFee = amount * retentionRate;
    let monthlyInterest = amount * interestRate; // per month interest
    let totalInterest = monthlyInterest * months;
    let netProceeds = amount - (serviceFee + retentionFee + totalInterest);
    let monthlyPayment = (amount + totalInterest) / months;
    let totalPayable = amount + totalInterest;

    return {
        loanType: "Bonanza",
        amount: amount,
        months: months,
        serviceFee: serviceFee,
        retentionFee: retentionFee,
        monthlyInterest: monthlyInterest,
        totalInterest: totalInterest,
        netProceeds: netProceeds,
        monthlyPayment: monthlyPayment,
        totalPayable: totalPayable
    };
}

// MPL placeholder (keeps previous behavior)
function calculateMPL(amount, months, interestRatePercent) {
    amount = parseFloat(amount);
    months = parseInt(months, 10);
    let interestRate = parseFloat(interestRatePercent) / 100;

    // simple diminishing schedule (approx)
    let monthlyPrincipal = amount / months;
    let remaining = amount;
    let schedule = [];
    let totalInterest = 0;

    for (let i = 1; i <= months; i++) {
        let interest = remaining * interestRate / 12;
        let payment = monthlyPrincipal + interest;
        totalInterest += interest;
        schedule.push({
            month: i,
            principal: monthlyPrincipal,
            interest: interest,
            payment: payment,
            remaining: Math.max(0, remaining - monthlyPrincipal)
        });
        remaining -= monthlyPrincipal;
    }

    return {
        loanType: "MPL",
        amount: amount,
        months: months,
        schedule: schedule,
        totalInterest: totalInterest,
        totalPayable: amount + totalInterest
    };
}

// Export
window.loanLogic = {
    calculatePettyCash,
    calculateBonanza,
    calculateMPL
};
