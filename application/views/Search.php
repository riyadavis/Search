<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Search</title>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>    
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="StyleSheet" type="text/css" href="<?php echo base_url()."assets/css/bootstrap.min.css"; ?>">
    <link rel="StyleSheet" type="text/css" href="<?php echo base_url()."assets/css/main.css"; ?>">
</head>
<body>
	<div class="container">
		<form action="">
			<input class="form-control" oninput="Trigger(event);" onchange="Details();" list="searches" name="search" id="search" type="search" placeholder="Search" aria-label="Search" style="width:50%;margin-top:3%;">
			<datalist id="searches"></datalist>
			<input type = "button" name = "submit" value = "search">
		</form>
		
	</div>
	<div id="demo"></div>
	<div class="modal" id="badModal">
	<div class="modal-dialog">
		<div class="modal-content">

		<!-- Modal Header -->
		<div class="modal-header">
			<h4 class="modal-title">Details</h4>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		</div>

		<!-- Modal body -->
		<div class="modal-body" >
			<div id="modalBody">    
					
			</div>
				
		</div>

		<!-- Modal footer -->
		<div class="modal-footer">
			<button type="button" class="btn btn-danger" data-dismiss="modal" id="modelBtn">Close</button>
		</div>

		</div>
	</div>
	</div>
</body>
<script>
	var datalist = document.getElementById("searches");
	var search = document.getElementById("search");

	var timeObj;
	var timeIntr = 800;

	function Trigger(event)
	{
		clearTimeout(timeObj);          
		if(event.inputType!=='deleteContentBackward')
		{
			timeObj = setTimeout(Search, timeIntr);
		}
	}

	async function Search()
	{
		document.getElementById('searches').innerHTML = "";
		let url = "<?php echo site_url('SearchApi/searchResult'); ?>?q="+search.value; 
		let request = await fetch(url);
		response = await request.json();
		console.log(response);
		response.map(r=>{
			option = document.createElement('option');
			if(response[0]['hub_name'])
			{
				option.value = r.hub_name;
				option.id = r.id;
			}
			else if(response[0]['product_tags'])
			{
				option.value = r.product_tags;
				option.id = r.id;
			}
			else
			{
				option.value = r.product_name;
				option.id = r.id;
			}
			datalist.appendChild(option);
			// console.log(option);
		});

		getLocation();
			function getLocation() {
				if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(showPosition);
				} else { 
					console.log("Geolocation is not supported by this browser.");
				}
			}

			function showPosition(position) {
				var lat = document.createElement("input");
					lat.value = position.coords.latitude;
					lat.id = "lat";
					lat.name = "lat";
					lat.type = "hidden";

				var long = document.createElement("input");
					long.value = position.coords.longitude;
					long.id = "long";
					long.name = "long";
					long.type = "hidden";
					
					locCoordinates();
				async function locCoordinates()
				{
					let url = "<?php echo site_url('SearchApi/locCoordinates'); ?>";
					let form = new FormData();
					form.append('lat',lat.value);
					form.append('long',long.value);
					let request = await fetch(url,{
						method : "post",
						body : form 
					});
					let response = await request.json();
					console.log(response);
				}
			
			}

	}

	function Details()
	{
		// document.getElementById('badModal').innerHTML = "";
		var hub = response.filter(r => r.hub_name == search.value);
		var tags = response.filter(r => r.product_tags == search.value);
		
		if(hub.length != 0)
		{
			
			var item = hub[0];
			var jsonData = JSON.stringify(item);
			console.log(jsonData);
			for(var i in item)
            {
                modalBody = document.getElementById('modalBody');
                var para = document.createElement('p');
                var textnode = document.createTextNode(i+' : '+item[i]);
                para.appendChild(textnode);
                modalBody.appendChild(para);
            }
            var img = document.createElement('img');
            img.src = '<?php echo base_url()."assets/img/";?>'+item['image'];
            img.width= 150;
            modalBody.appendChild(img);
            
            $('#badModal').modal('show');
			
		}
		else if(tags.length != 0)
		{
			var item = tags[0];
			var jsonData = JSON.stringify(item);
			shopDetails(item);
		}
		else 
		{
			var product = response.filter(r =>r.product_name == search.value);
			var item = product[0];
			var jsonData = JSON.stringify(item);
			shopDetails(item);
			
			// console.log(jsonData);
			for(var i in item)
            {
                modalBody = document.getElementById('modalBody');
                var para = document.createElement('p');
                var textnode = document.createTextNode(i+' : '+item[i]);
                para.appendChild(textnode);
                modalBody.appendChild(para);
            }
            var img = document.createElement('img');
            img.src = '<?php echo base_url()."assets/img2/";?>'+item['product_image'];
            img.width= 150;
            modalBody.appendChild(img);
            
            $('#badModal').modal('show');		
		}
		
	}
	async function shopDetails(item)
		{
			let url = "<?php echo site_url('SearchApi/shopDetails'); ?>";
			// let hubId = document.createElement('input');
			// hubId.value = item['hub_id'];
			// hubId.id = "hubId";
			// hubId.name = "hubId";
			// hubId.type = "hidden";
			let productName = document.createElement('input');
				productName.value = item['product_name'];
				productName.name = "productName";
				productName.id = "productName";
				productName.type = "hidden";
			let form = new FormData();
			// form.append('hubId',hubId.value);
			form.append('productName',productName.value);
			// console.log(hubId);
			let request = await fetch(url,{
				method : "post",
				body : form
			});
			let response = await request.json();
			console.log(response);
		}
</script>
<script src="<?php echo base_url().'assets/js/bootstrap.min.js';?>"></script>
</html>