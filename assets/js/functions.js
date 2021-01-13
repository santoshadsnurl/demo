var WEBPATH = window.location.protocol+'//'+window.location.host+'/ramanta/';
var CARTPATH = window.location.protocol+'//'+window.location.host+'/ramanta/cart/';
var checkout = window.location.protocol+'//'+window.location.host+'/ramanta/checkout-to-ship/';

function disablePopup()
{
	// if value is 1, close popup
	$("#toPopup").fadeOut("normal");  
	$("#backgroundPopup").fadeOut("normal");  
	popupStatus = 0;  // and set value to 0
}

function callAuto()
{
	jQuery(function($)
	{
		$(document).ready(function() {
		//loading(); // loading
		setTimeout(function()
		{ 
			// then show popup, deley in .5 second
			loadPopup(); // function show popup 
		}, 1); // .5 second
		return false;
	});
	
	/* event for close the popup */
	$("div.close").hover(
		function()
		{
			$('span.ecs_tooltip').show();
		},
		function()
		{
			$('span.ecs_tooltip').hide();
		});
		
		$("div.close").click(function()
		{
			disablePopup();  // function close pop up
		});
		
		$(this).keyup(function(event)
		{
			if(event.which == 27)
			{ 
				// 27 is 'Ecs' in the keyboard
				disablePopup();  // function close pop up
			}
		});
		
		$("div#backgroundPopup").click(function()
		{
			disablePopup();  // function close pop up
		});
		
		$('a.livebox').click(function()
		{
			alert('Hello World!');
			return false;
		});
		
		/************** start: functions. **************/
		function loading()
		{
			$("div.loader").show();
		}
		
		function closeloading()
		{
			$("div.loader").fadeOut('normal');
		}
		
		var popupStatus = 0; // set value
		
		function loadPopup()
		{
			if(popupStatus == 0)
			{ 
				// if value is 0, show popup
				closeloading(); // fadeout loading
				$("#toPopup").fadeIn(0500); // fadein popup div
				$("#backgroundPopup").css("opacity", "0.7"); // css opacity, supports IE7, IE8
				$("#backgroundPopup").fadeIn(0001); 
				popupStatus = 1; // and set value to 1
			}
		}
		
		function disablePopup()
		{
			if(popupStatus == 1)
			{ 
				// if value is 1, close popup
				$("#toPopup").fadeOut("normal");  
				$("#backgroundPopup").fadeOut("normal");  
				popupStatus = 0;  // and set value to 0
			}
		}
		
		/************** end: functions. **************/
	}); // jQuery End		
}

function BuyNow(product_id)
{
	
	var quantity = 1;
	var product_size = $('#product_size').val();
	var product_color = $('#product_color').val();
	var product_material = $('#product_material').val();

	$(document).ready(function()
	{
		var proceed = "add";
		$.ajax({
			type: "GET",
			url: WEBPATH+"cartprogress.php?",
			data: "product_id="+product_id+"&product_quantity="+quantity+"&product_size="+product_size+"&product_color="+product_color+"&product_material="+product_material+"&proceed="+proceed,
			success: function(response)
			{
				window.location.replace(checkout);
			}
		});
	});
}

function AddCart(product_id)
{
	var quantity = 1;
	var product_size = $('#product_size').val();
	var product_color = $('#product_color').val();
	var product_material = $('#product_material').val();

	$(document).ready(function()
	{
		var proceed = "add";
		$.ajax({
			type: "GET",
			url: WEBPATH+"cartprogress.php?",
			data: "product_id="+product_id+"&product_quantity="+quantity+"&product_size="+product_size+"&product_color="+product_color+"&product_material="+product_material+"&proceed="+proceed,
			success: function(response)
			{
				alert(response);
				if(response==" Out Of Stock !")
				{
					$('#loadmsgpromo').html(response);
				}
				else
				{
					var str = response;
					$('#loadmsgpromo').html('Added to cart!');
					$('#carthtml').html(str);
				}
				callAuto();
				setTimeout(function() { disablePopup(); }, 2000); 
			}
		});
	});
}

function Addcol(col)
{
	document.getElementById('product_color').value = col;
}

function Addsize(size)
{
	document.getElementById('product_size').value = size;
}

function Addmat(mat)
{
	document.getElementById('product_material').value = mat;
}

function GetColor(col,colid,num)
{
	//alert(num);
	for (i = 1; i <=num; i++) 
	{ 
		document.getElementById("vldcol"+i).classList.remove("colcls");
	}
	document.getElementById("vldcol"+colid).classList.add("colcls");
	document.getElementById('color').value = col;
}

function AddSingleCart(product_id)
{
	//alert("san");
	//alert(product_id);
	var quantity = $('#quantity').val();
	var size = $('#product_size').val();
	//alert(quantity);
	//alert(size);
	if(quantity=="" || quantity<=0 || isNaN(quantity))
	{
		$('#loadmsgpromo').html("Please Select Quantity");
		callAuto();
		setTimeout(function() { disablePopup(); }, 2000); 
	}
	else if(size=="")
	{
		$('#loadmsgpromo').html("Please Select Size");
		callAuto();
		setTimeout(function() { disablePopup(); }, 2000); 
	}
	else 
	{
		$(document).ready(function()
		{
			var proceed = "add";
			$.ajax({
				type: "GET",
				url: WEBPATH+"cartprogress.php?",
				data: "product_id="+product_id+"&product_quantity="+quantity+"&product_size="+size+"&proceed="+proceed,
				success: function(response)
				{
					//alert(response);
					var str = response;
					var res = str.split("~");
					var total = res[0];
					var msg = res[1];
					$('#totalincart').addClass('count');
					$('#totalincart').html(total);
					$('#loadmsgpromo').html(msg);
					callAuto();
					setTimeout(function() { disablePopup(); }, 2000); 
				}
			});
		});
	}
}

function UpdateProduct(updateprodidval,productid)
{
	var updateprodidval = parseInt(updateprodidval);
	//var gross_total = parseInt(gross_total);
	//alert(updateprodid);
	//alert(updateprodidval);
	//alert(productid);
	//alert(gross_total);
	
	if(!isNaN(updateprodidval) && updateprodidval>0 && updateprodidval!="")
	{
		var product_quantity = updateprodidval;
		var product_id = productid;
		var proceed = "update";
	}
	else
	{
		alert("Please Enter Only Numeric Value Grater Than 0");
		return false;
		//location.reload();
	}
	$.ajax({
		type: "GET",
		url: WEBPATH+"cartprogress.php?",
		data: "product_id="+product_id+"&product_quantity="+product_quantity+"&proceed="+proceed,
		success: function(response)
		{
			//alert(response);
			var str = response;
			var res = str.split("~");
			var sub_total = res[0];
			var msg = res[1];
			$('#subtotaltothtml').html(sub_total);
			$('#loadmsgpromo').html(msg);
			callAuto();
			//setTimeout(function() { disablePopup(); window.location.replace(CARTPATH); }, 200); 
			//window.location(CARTPATH);
			setTimeout(function() { disablePopup(); }, 2000); 
		}
	});
}

function DeleteProduct(product_id)
{
	//alert(product_id);
	var product_id = product_id;
	if(product_id!="")
	{
		var confrm = confirm('Do you really want to delete this product');
		if(confrm == true)
		{	
			document.getElementById("product_id").value = product_id;
			document.getElementById('proceed').value = "delete";
			document.Cart.submit();
		}
		else
		{
			return false;
		}
	}
	else
	{
		location.reload();
		return false;
	}
}

function wishlist()
{
	//alert("san");
	var response = "Login First";
	$('#loadmsgpromo').html(response);
	callAuto();
	setTimeout(function() { disablePopup(); }, 2000); 
}

function addwishlist(product_id)
{
	//alert(product_id);
	var action = "add";
	$(document).ready(function()
	{
		$.ajax({
			type: "GET",
			url: WEBPATH+"wishlist.php?",
			data: "product_id="+product_id+"&action="+action,
			success: function(response)
			{
				//alert(response);
				if(response=="Product Successfully Added to Wishlist!")
				{
					$('#loadmsgpromo').html(response);
					$('#changeimg'+product_id).html('<img src='+WEBPATH+'images/heartfill.png>');
				}
				else
				{
					$('#loadmsgpromo').html(response);
				}
				callAuto();
				setTimeout(function() { disablePopup(); }, 2000); 
			}
		});
	});
}

function removewishlist(product_id)
{
	//alert(product_id);
	var confrm = confirm('Do you really want to remove this product');
	if(confrm == true)
	{	
		var action = "delete";
		$(document).ready(function()
		{
			$.ajax({
				type: "GET",
				url: WEBPATH+"wishlist.php?",
				data: "product_id="+product_id+"&action="+action,
				success: function(response)
				{
					//alert(response);
					if(response=="Product Successfully Deleted to Wishlist!")
					{
						document.location.href = WEBPATH+'my-wishlist'
					}
					else
					{
						$('#loadmsgpromo').html(response);
					}
					callAuto();
					setTimeout(function() { disablePopup(); }, 2000); 
				}
			});
		});
	}
	else
	{
		return false;
	}
			
}

function popmsz(response)
{
	//alert(response);
	$('#loadmsgpromo').html(response);
	callAuto();
	setTimeout(function() { disablePopup(); }, 2000); 
}