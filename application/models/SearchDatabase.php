<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SearchDatabase extends CI_Model {

    public function searchResult()
    {
        $searchItem = $_GET['q'];

        $searchShop = $this->db->query("select count(*) as count from distributor_hub where hub_name like '%$searchItem%'")->result_array();
        $shopSearchCount = $searchShop[0]['count'];
        $totalShop = $this->db->query("select count(*) as count from distributor_hub")->result_array();
        $totalShopCount = $totalShop[0]['count'];

        $searchProduct = $this->db->query("select count(*) as count from product where product_name like '%$searchItem%'")->result_array();
        $productSearchCount = $searchProduct[0]['count'];
        $totalProduct = $this->db->query("select count(*) as count from product")->result_array();
        $totalProductCount = $totalProduct[0]['count'];

        $shopProbability = $shopSearchCount/$totalShopCount;
        $productProbability = $productSearchCount/$totalProductCount;

        $highestProbability = max($shopProbability,$productProbability);

        if($highestProbability == $shopProbability)
        {
            $shopLists = $this->db->query("select id,hub_name,pickup_address,image from distributor_hub where hub_name like '%$searchItem%'")->result_array();
            return $shopLists;
        }
       else
       {
            $productLists = $this->db->query("select id,hub_id,product_name,product_image,product_price from product where product_name like '%$searchItem%'")->result_array();
            return $productLists;
       }
    }

    public function shopDetails()
    {
        $productName = $this->input->post('productName');
        $productHub = $this->db->query("select hub_id from product where product_name = '$productName'")->result_array();
        $sessionShop = $this->session->userdata('nearid');
        // $this->db->where_in('id',$sessionShop);
        //     $this->db->where_in('id',$productHub);
        //         $availableShops = $this->db->get('distributor_hub')->result_array();
        return $productHub;
    }
   

    public function locCoordinates()
    {
        $userLat = $this->input->post('lat');
        $userLong = $this->input->post('long');
        $totalShop = $this->db->query("select count(*) as count from distributor_hub")->result_array();
        $totalShopCount = $totalShop[0]['count'];
        $shopCoor = $this->db->query("select * from distributor_hub")->result_object();
        // $coordinates = json_decode($shop[0]['location_coordinate'],true);
        // $latitude = $coordinates['latitude'];
        // $lonigtude = $coordinates['longitude'];
        // $e = $this->db->query("select * from distributor_hub")->result_object();
            for($i = 0;$i<$totalShopCount;$i++)
            {
                $coord = json_decode($shopCoor[$i]->location_coordinate);
                $id[] = json_decode($shopCoor[$i]->id);
                $lat[] = $coord->latitude;
                $long[] = $coord->longitude; 
            }
            // return $l;
            // $userLat=10.050628;
            // $userLng=76.329600;
            $latmax = $userLat + 0.089904;
            $latmin = $userLat - 0.089904; 
            
            // $radius=10;
            for($i = 0; $i<$totalShopCount;$i++)
            {
                if($lat[$i] < $latmax && $lat[$i] > $latmin)
                {
                    $nearId[] = $id[$i];
                    
                }
            }
            $this->db->where_in('id',$nearId);
               $nearShop =  $this->db->get('distributor_hub')->result_array();
                $this->session->set_userdata('nearid',$nearId);  
            // $this->shopDetails($nearShop);
            return $nearShop;
        // return $lat;
    }

    
    public function shop()
    {
        $location = array('latitude'=>$this->input->post('latitude'),
                            'longitude'=>$this->input->post('longitude'));
        $pickupAddress = array('Address'=>$this->input->post('pickup'),
                                'Landmark'=>$this->input->post('landmark'),
                                'mobile'=>$this->input->post('mobile'));
        $this->db->trans_start();
            $this->db->where('id',8);
            $this->db->set('location_coordinate',json_encode($location));
            $this->db->set('pickup_address',json_encode($pickupAddress));
            $this->db->update('distributor_hub');
        $this->db->trans_complete();
        return $pickupAddress;
        
    }

    public function b($data = '')
    {
        return var_dump($data);
    }
    
    public function c()
    {
        $data = 1;
        b("hello");
        // $hubId = 1;
        // $shop = $this->db->query("select * from distributor_hub where id = '$hubId'")->result_array();
        // $coordinates = json_decode($shop[0]['location_coordinate'],true);
        // $latitude = $coordinates['latitude'];
        // $lonigtude = $coordinates['longitude'];
        // $userLat=10.050628;
        // $userLng=76.329600;
        // $radius=10;
        // // $query = $this->db->query("SELECT shops, ( 3959 * acos( cos( radians('".$userLat."') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('".$lng."') ) + sin( radians('".$userLat."') ) * sin( radians( lat ) ) ) ) AS distance FROM gettable HAVING distance < '".$radius."' ORDER BY distance LIMIT 0 , 20");
        // // return($query->result_array()); 
        // // $shopCoor = $this->db->query("select id,json_extract(location_coordinate,'$.latitude') ,json_extract(location_coordinate,'$[longitude]')  from distributor_hub")->result_array();
        // // $decode = json_decode($shopCoor);
        $totalShop = $this->db->query("select count(*) as count from distributor_hub")->result_array();
        $totalShopCount = $totalShop[0]['count'];
        // // for($i=0; $i<$totalShopCount;$i++)
        // {
        //     $coordinates[$i] = json_decode($shop[$i]['location_coordinate'],true);
        //     $latitude[$i] = $coordinates['latitude'];
        //     $longitude[$i] = $coordinates['longitude'];
        // }
        
            
            // $coordinates = json_decode($shop[0]['location_coordinate'],true);
            
     
        // $latitude[$i] = $coordinates['latitude'];
        //     $longitude[$i] = $coordinates['longitude'];
        // $e = $this->db->query("select location_coordinate->latitude from distributor_hub")->result_array();
    //    $e = $this->db->query("select id,location_coordinate from distributor_hub ")->result_object();
    // //    $q = json_decode($e[0]->location_coordinate);
    // //    $l = json_decode($e[0]->id);
    //    return $e;
    //    $d = json_decode($e->location_coordinate);
    //    return var_dump(json_decode($e[0]->location_coordinate)->latitude);
    //    $r = json_decode($e,true);
    $e = $this->db->query("select * from distributor_hub")->result_object();
            for($i = 0;$i<$totalShopCount;$i++)
            {
                $q = json_decode($e[$i]->location_coordinate);
                $l[] = json_decode($e[$i]->id);
                $y[] = $q->latitude;
                $z[] = $q->longitude; 
            }
            // return $l;
            $userLat=10.050628;
            $userLng=76.329600;
            $latmax =10.510005;
            $latmin =10.000500; 
            
            // $radius=10;
            for($i = 0; $i<$totalShopCount;$i++)
            {
                if($y[$i] < $latmax && $y[$i] > $latmin)
                {
                    $ip[] = $l[$i];
                    
                }
            }
            return $ip;
           
           
            // $query = $this->db->query("SELECT
            //     `id`,
            //     ACOS( SIN( RADIANS( `latitude` ) ) * SIN( RADIANS( $fLat ) ) + COS( RADIANS( `latitude` ) )
            //     * COS( RADIANS( $fLat )) * COS( RADIANS( `longitude` ) - RADIANS( $fLon )) ) * 6380 AS `distance`
            //     FROM `stations`
            //     WHERE
            //     ACOS( SIN( RADIANS( `latitude` ) ) * SIN( RADIANS( $fLat ) ) + COS( RADIANS( `latitude` ) )
            //     * COS( RADIANS( $fLat )) * COS( RADIANS( `longitude` ) - RADIANS( $fLon )) ) * 6380 < 10
            //     ORDER BY `distance`")->result_array();
            // $query = $this->db->query("SELECT id, ( 6371 * acos( cos( radians('".$userLat."') ) * cos( radians( location_coordinate['latitude'] ) ) * cos( radians( location_coordinate['longitude'] ) - radians('".$userLng."') ) + sin( radians('".$userLat."') ) * sin( radians( location_coordinate['latitude'] ) ) ) ) AS distance FROM distributor_hub HAVING distance < '".$radius."' ORDER BY distance LIMIT 0 , 20")->result_array();
            return $e;
        //   return $q[0]->latitude;
            // for($i = 0;$i<5;$i++)
            // {
            //     $p[] = $q[$i]['latitude'];
            // }
            // return var_dump($e);
                // return var_dump($q);
            // return var_dump(json_decode($q)->latitude);
            // return $z;
    }
}

