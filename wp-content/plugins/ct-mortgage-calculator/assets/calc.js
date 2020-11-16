/**
 * Calc
 *
 * @package CT Mortgage Calculator
 * @subpackage JavaScript
 */

jQuery("#mortgageCalc").click(function () {

    var L, P, n, c, dp;

    let mcTerm = jQuery("#mcTerm").val();
    n = parseInt(mcTerm) * 12;
    let mcRate = jQuery("#mcRate").val();
    c = parseFloat(mcRate);
    let mcPrice = jQuery("#mcPrice").val().replace(/[,|$]/g, "");
    L = parseInt(mcPrice) - parseFloat(jQuery("#mcDown").val());

    // If 0 or no interest, fake it with a tiny number to avoid NaN error
    if (c == 0) {
        c = .00001;
    }
    c = c / 1200;

    P = (L * (c * Math.pow(1 + c, n))) / (Math.pow(1 + c, n) - 1);

    if (!isNaN(P)) {
        jQuery("#mcPayment").text(P.toFixed(2));
    } else {
        jQuery("#mcPayment").val('There was an error');
    }
    return false;

});