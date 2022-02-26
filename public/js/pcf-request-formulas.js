const item_inputs = document.querySelectorAll('#unit_price_item, #quantity_item');
item_inputs.forEach(i => {
    i.addEventListener('input', function() {
        console.log('gumana');
        calculateItemListOpex();
        calculateItemListNetSales();
        calculateItemListTotalSales();
        calculateItemListGrossProfit();
        calculateItemListTotalGrossProfit();
        calculateItemListTotalNetSales();
        calculateItemListProfitRatePerItem();
        getGrandTotalProfit();
    });
})

const inclusion_inputs = document.querySelectorAll('#quantity_inclusion');
inclusion_inputs.forEach(i => {
    i.addEventListener('input', function() {
        calculateInclusionListOpex();
        calculateInclusionTotalCost();
        calculateInclusionTotalCostPerYear();

        getGrandTotalProfit();
    });
})

function calculateItemListOpex() {
    var currency_rate_item = $("#currency_rate_item").val();
    var total_price_item = $("#tp_php_item").val();
    
    if (parseInt(currency_rate_item) == 1 ) {
        var opex_item = total_price_item * 1.15;
    } else if (parseInt(currency_rate_item) > 1) {
        var opex_item = total_price_item * 1.35;
    } 

    console.log(opex_item);
    // $("#opex_item").val(opex_item.toFixed(2));
}

function calculateInclusionListOpex() {
    var total_price_inclussion = $("#tp_php_inclusion").val();
    var currency_rate_inclussion = $("#currency_rate_inclusion").val();

    if (parseInt(currency_rate_inclussion) == 1) {
        var opex_inclusion = total_price_inclussion * 1.15;
    } else if (parseInt(currency_rate_inclussion) > 1) {
        var opex_inclusion = total_price_inclussion * 1.35;
    }

    $("#opex_inclusion").val(opex_inclusion.toFixed(2));
}

function calculateItemListNetSales() {
    var unit_price_item = $("#unit_price_item").val();
    var net_sales_item = unit_price_item / 1.12;

    $("#net_sales_item").val(net_sales_item.toFixed(2));
}

function calculateItemListTotalSales() {
    var quantity_item = $("#quantity_item").val();
    var unit_price_item = $("#unit_price_item").val();
    var total_sales_item = unit_price_item * quantity_item;

    $("#total_sales_item").val(total_sales_item.toFixed(2));
}

function calculateItemListGrossProfit() {
    var net_sales_item = $("#net_sales_item").val();
    var opex_item = $("#opex_item").val();
    var total_cost_mandatory_peripheral_item = $("#cost_of_peripherals_item").val();
    var gross_profit_item = (net_sales_item - opex_item) - total_cost_mandatory_peripheral_item;

    $("#gross_profit_item").val(gross_profit_item.toFixed(2));
}

function calculateItemListTotalGrossProfit() {
    var gross_profit_item = $("#gross_profit_item").val();
    var quantity_item = $("#quantity_item").val();
    var total_gross_profit_item = gross_profit_item * quantity_item;

    $("#total_gross_profit_item").val(total_gross_profit_item.toFixed(2));
}

function calculateItemListTotalNetSales() {
    var total_sales_item = $("#total_sales_item").val();
    var total_net_sales_item = total_sales_item / 1.12;

    $("#total_net_sales_item").val(total_net_sales_item.toFixed(2));
}

function calculateItemListProfitRatePerItem() {
    var gross_profit_item = $("#gross_profit_item").val();
    var net_sales_item = $("#net_sales_item").val();
    var profit_rate_item = (gross_profit_item / net_sales_item) * 100;

    $("#profit_rate_item").val(profit_rate_item.toFixed(2));
}

function calculateInclusionTotalCost() {
    var quantity_inclusion = $("#quantity_inclusion").val();
    var opex_inclusion = $("#opex_inclusion").val();
    var total_cost_inclusion = quantity_inclusion * opex_inclusion;

    $("#total_cost_inclusion").val(total_cost_inclusion.toFixed(2));
}

function calculateInclusionTotalCostPerYear() {
    var total_cost_inclusion = $("#total_cost_inclusion").val();
    var depreciable_life_inclusion = $("#depreciable_life_inclusion").val();
    var total_cost_per_year_inclusion = total_cost_inclusion / depreciable_life_inclusion;

    $("#total_cost_per_year_inclussion").val(total_cost_per_year_inclusion.toFixed(2));
}

function getGrandTotalProfit() {
    var pcf_no = $("#pcf_no").val();
    if (pcf_no) {
        $.ajax({
            method: 'GET',
            url: '/PCF.sub/ajax/get-grand-total-profit/' + pcf_no,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        }).done(function(response) {
            var total_gross_profit = $("#total_gross_profit_item").val();
            var total_cost_per_year_inclusion = $("#total_cost_per_year_inclussion").val();
            
            var total_grand_profit = (parseFloat(total_gross_profit) + parseFloat(response.sumTotalGrossProfit)) - (parseFloat(total_cost_per_year_inclusion) +parseFloat(response.sumTotalCostPerYear));
            $("#annual_profit").val(total_grand_profit);
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
        });
    }
}