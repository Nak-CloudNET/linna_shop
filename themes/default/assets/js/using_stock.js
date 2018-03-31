/* ---------------------- 
 * On Edit 
 * ---------------------- */

if (localStorage.getItem('poitems')) {
    loadItems();
}

/* ---------------------- 
 * Delete Row Method 
 * ---------------------- */

$(document).on('click', '.usdel', function () {
    var parent = $(this).parent().parent();
	parent.remove();
});
var delete_pro_id = "";
$(document).on('click', '.btn_delete', function () {
   delete_pro_id += ($(this).attr("id")+"_");
   $('#store_del_pro_id').val(delete_pro_id);
});

/* ---------------------- 
 * Keep Warehouse when reload
 * ---------------------- */

$('#from_location').change(function (e) {
	localStorage.setItem('from_location', $(this).val());
});

if (from_location = localStorage.getItem('from_location')) {
	$('#from_location').val(from_location);
}

$('#authorize_id').change(function (e) {
	localStorage.setItem('authorize_id', $(this).val());
});

if (authorize_id = localStorage.getItem('authorize_id')) {
	$('#authorize_id').val(authorize_id);
}   

$('#employee_id').change(function (e) {
	localStorage.setItem('employee_id', $(this).val());
});

if (employee_id = localStorage.getItem('employee_id')) {
	$('#employee_id').val(employee_id);
} 

$('#shop').change(function (e) {
	localStorage.setItem('shop', $(this).val());
});

if (shop = localStorage.getItem('shop')) {
	$('#shop').val(shop);
}  

$('#account').change(function (e) {
	localStorage.setItem('account', $(this).val());
});

if (account = localStorage.getItem('account')) {
	$('#account').val(account);
}       

/* ---------------------- 
 * Clear LocalStorage 
 * ---------------------- */

$('#reset').click(function (e) {
	bootbox.confirm(lang.r_u_sure, function (result) {
		if (result) {
			if (localStorage.getItem('poitems')) {
				localStorage.removeItem('poitems');
			}
			if (localStorage.getItem('from_location')) {
				localStorage.removeItem('from_location');
			}
			if (localStorage.getItem('authorize_id')) {
				localStorage.removeItem('authorize_id');
			}
			if (localStorage.getItem('employee_id')) {
				localStorage.removeItem('employee_id');
			}
			if (localStorage.getItem('shop')) {
				localStorage.removeItem('shop');
			}
			if (localStorage.getItem('account')) {
				localStorage.removeItem('account');
			}
			$('#modal-loading').show();
			location.reload();
		}
	});
});

function loadItems() {
    if (localStorage.getItem('poitems')) {
		//============ Return From View ==============//
        count 	= 1;
		//=================== End ====================//
        //$("#UsData tbody").empty();
        poitems = JSON.parse(localStorage.getItem('poitems'));
		var no_ = 1;
		$('#from_location').select2("readonly", true);
		item_description = '';
		item_reason      = '';
		item_qty_use     = '';
		item_qty_by_unit     = '';
        $.each(poitems, function () {
            var item = this;
            var item_id = site.settings.item_addition == 1 ? item.item_id : item.id;
            poitems[item_id] = item;
			var product_id = item.item_id, item_code = item.code, item_name = item.name, item_label = item.label, qoh = item.qoh, unit_name = item.unit_name, item_cost = item.cost, item_unit = item.unit, stock_item_id = item.stock_item;
			var opt = $("<select id=\"unit\" name=\"unit\[\]\" style=\"padding-top: 2px !important;\" class=\"form-control\" />");
            if(item.option_unit !== false) {
                $.each(item.option_unit, function () {
				  if(item.unit == this.unit_variant){
					$("<option />", {value: this.unit_variant, text: this.unit_variant, selected: 'selected'}).appendTo(opt);
				  }else{
					$("<option />", {value: this.unit_variant, text: this.unit_variant}).appendTo(opt);  
				  }
				});
            } else {
                $("<option />", {value: 0, text: 'n/a'}).appendTo(opt);
                opt = opt.hide();
            }
			
			if(item.description){
				item_description = item.description;
			}
			
			if(item.reason){
				item_reason = item.reason;
			}
			
			if(item.qty_use){
				item_qty_use = formatMoney(item.qty_use);
			}
			if(item.qty_by_unit){
				item_qty_by_unit = item.qty_by_unit;
			}
			var row_no = (new Date).getTime();
			
			var newTr = $('<tr id="row_' + row_no + '" class="row_' + item_id + '" data-item-id="' + item_id + '"></tr>');
			
			
			tr_html = '<td><input type="hidden" value="'+ product_id +'" name="product_id[]"/><input type="hidden" value="'+ item_code +'" name="item_code[]"/><input type="hidden" value="'+ item_name +'" name="name[]"/><input type="hidden" value="'+ item_cost +'" name="cost[]"/> <input type="hidden" value="'+ stock_item_id +'" name="stock_item_id[]"/>'+ item_label +'</td>';
						
			tr_html += '<td><input type="text" value="'+ item_description +'" class="form-control" name="description[]"/></td>';
			
			//tr_html += '<td class="text-center"><input type="hidden" value="" class="form-control" name="net_cost[]"/>'+ formatMoney(item_cost) +'</td>';
			
			tr_html += '<td class="text-center">'+ formatQuantity2(qoh) +'</td>';
			
			tr_html += '<td><input type="text" value="'+ item_qty_by_unit +'" class="form-control" name="qty_use[]" style="text-align:center !important;"/></td>';
			
			tr_html += '<td>'+(opt.get(0).outerHTML)+'</td>';
			
			tr_html += '<td class="text-center"><i class="fa fa-times tip usdel btn_delete" id="' + product_id + '" title="Remove" style="cursor:pointer;"></i></td>';
			
			newTr.html(tr_html);
            newTr.appendTo("#UsData");
			
        });
    }
}

/* -----------------------------
 * Add Using Stock Iten Function
 * @param {json} item
 * @returns {Boolean}
 ---------------------------- */
function add_using_stock_item(item) {
	
    if (count == 1) {
        poitems = {};
        if ($('#from_location').val() ) {
            $('#from_location').select2("readonly", true);
        } else {
            bootbox.alert("Please select supplier and warehouse.");
            item = null;
            return;
        }
    }
    if (item == null) {
        return;
    }
    var item_id = site.settings.item_addition == 1 ? item.item_id : item.id;
    if (poitems[item_id]) {
        poitems[item_id].row.qty = parseFloat(poitems[item_id].row.qty) + 1;
    } else {
        poitems[item_id] = item;
    }
    
    localStorage.setItem('poitems', JSON.stringify(poitems));
    loadItems();
    return true;

}


