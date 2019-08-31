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
        <form action="">
                <input type="text" name="latitude" id="latitude" placeholder="enter location latitude"><br><br>
                <input type="text" name="longitude" id="longitude" placeholder="enter location longitude"><br><br>
                
                <textarea name="pickup" id="pickup" rows="5"></textarea><br><br>
                <input type="text" name="landmark" id="landmark" placeholder="enter landmark"><br><br>
                <input type="text" name="mobile" id="mobile" placeholder="mobile"><br><br>
                <input type="button" name="submit" id="submit" value="submit" onclick="Add();">
        </form>
    </body>
    <script>
            
            async function Add()
            {
                var latitude = document.getElementById('latitude').value;
                var longitude = document.getElementById('longitude').value;
                var pickup  = document.getElementById('pickup').value;
                var landmark = document.getElementById('landmark').value;
                var mobile = document.getElementById('mobile').value;
            // var coord = latitude+longitude;
            // console.log(JSON.stringify(latitude));
                let url = "<?php echo site_url('SearchApi/shop');?>";
                let form = new FormData();
                form.append('latitude',JSON.stringify(latitude));
                form.append('longitude',JSON.stringify(longitude));
                form.append('pickup',JSON.stringify(pickup));
                form.append('landmark',JSON.stringify(landmark));
                form.append('mobile',JSON.stringify(mobile));
                // form.append('')
                let request = await fetch(url,{
                    method : "post",
                    body : form
                });
            
            }
    </script>
    <script src="<?php echo base_url().'assets/js/bootstrap.min.js';?>"></script>
</html>